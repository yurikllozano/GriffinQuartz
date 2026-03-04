<?php
/**
 * Griffin Quartz - Media Manager (Cloudflare Images)
 * Zero-database design with folder system via filename prefixes
 */
require_once __DIR__ . '/includes/admin-auth.php';
require_admin_login();
require_once dirname(__DIR__) . '/includes/config/cloudflare.php';

/**
 * Make Cloudflare API request
 */
function cfRequest($method, $endpoint, $data = null, $isUpload = false) {
    $url = "https://api.cloudflare.com/client/v4/accounts/" . CLOUDFLARE_ACCOUNT_ID . "/images/v1{$endpoint}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    $headers = ["Authorization: Bearer " . CLOUDFLARE_API_TOKEN];

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
    } elseif ($method === 'DELETE') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return ['success' => false, 'error' => $error];
    }

    return json_decode($response, true);
}

/**
 * Get delivery URL for an image
 */
function getImageUrl($imageId) {
    return "https://imagedelivery.net/" . CLOUDFLARE_ACCOUNT_HASH . "/{$imageId}/" . CLOUDFLARE_DEFAULT_VARIANT;
}

// Handle AJAX actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $action = $_POST['action'] ?? '';

    if ($action === 'list') {
        $result = cfRequest('GET', '?per_page=10000');

        if ($result['success'] ?? false) {
            $images = [];
            foreach ($result['result']['images'] ?? [] as $img) {
                $images[] = [
                    'id' => $img['id'],
                    'url' => getImageUrl($img['id']),
                    'filename' => $img['filename'] ?? 'image',
                    'uploaded' => $img['uploaded'] ?? ''
                ];
            }
            echo json_encode(['success' => true, 'images' => $images, 'total' => count($images)]);
        } else {
            echo json_encode(['success' => false, 'error' => $result['errors'][0]['message'] ?? 'API error']);
        }
        exit;
    }

    if ($action === 'upload' && isset($_FILES['image'])) {
        $file = $_FILES['image'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'error' => 'Upload failed']);
            exit;
        }

        $data = [
            'file' => new CURLFile($file['tmp_name'], $file['type'], $file['name']),
            'metadata' => json_encode(['source' => 'admin'])
        ];

        $result = cfRequest('POST', '', $data, true);

        if ($result['success'] ?? false) {
            $img = $result['result'];
            echo json_encode([
                'success' => true,
                'image' => ['id' => $img['id'], 'url' => getImageUrl($img['id'])]
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => $result['errors'][0]['message'] ?? 'Upload failed']);
        }
        exit;
    }

    if ($action === 'delete') {
        $imageId = $_POST['image_id'] ?? '';
        if ($imageId) {
            $result = cfRequest('DELETE', '/' . $imageId);
            echo json_encode(['success' => $result['success'] ?? false]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No image ID']);
        }
        exit;
    }

    if ($action === 'export_links') {
        $images = json_decode($_POST['images'] ?? '[]', true);
        if (empty($images)) {
            echo json_encode(['success' => false, 'error' => 'No images selected']);
            exit;
        }

        $lines = [];
        foreach ($images as $img) {
            $lines[] = ($img['filename'] ?? 'image') . "\t" . $img['url'];
        }
        $content = implode("\n", $lines);
        echo json_encode(['success' => true, 'content' => $content, 'filename' => 'image-links-' . date('Y-m-d') . '.txt']);
        exit;
    }

    if ($action === 'move_images') {
        $targetFolder = $_POST['target_folder'] ?? '';
        $images = json_decode($_POST['images'] ?? '[]', true);

        if (empty($images)) {
            echo json_encode(['success' => false, 'error' => 'No images selected']);
            exit;
        }

        $targetFolder = $targetFolder ? preg_replace('/[^a-zA-Z0-9_-]/', '-', strtolower($targetFolder)) : '';
        $results = ['success' => 0, 'failed' => 0, 'errors' => []];

        foreach ($images as $img) {
            $imageData = @file_get_contents($img['url']);
            if (!$imageData) {
                $results['failed']++;
                continue;
            }

            $oldFilename = $img['filename'];
            $baseName = preg_replace('/^[a-zA-Z0-9_-]+_/', '', $oldFilename);
            $newFilename = $targetFolder ? $targetFolder . '_' . $baseName : $baseName;

            $tempFile = sys_get_temp_dir() . '/' . uniqid() . '_' . $newFilename;
            file_put_contents($tempFile, $imageData);

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tempFile);
            finfo_close($finfo);

            $uploadData = [
                'file' => new CURLFile($tempFile, $mimeType, $newFilename),
                'metadata' => json_encode(['source' => 'admin'])
            ];

            $uploadResult = cfRequest('POST', '', $uploadData, true);
            unlink($tempFile);

            if ($uploadResult['success'] ?? false) {
                cfRequest('DELETE', '/' . $img['id']);
                $results['success']++;
            } else {
                $results['failed']++;
            }
        }

        echo json_encode([
            'success' => $results['failed'] === 0,
            'message' => "Moved {$results['success']} images" . ($results['failed'] > 0 ? ", {$results['failed']} failed" : ""),
            'details' => $results
        ]);
        exit;
    }

    if ($action === 'rename_folder') {
        $oldFolder = $_POST['old_folder'] ?? '';
        $newFolder = $_POST['new_folder'] ?? '';
        $images = json_decode($_POST['images'] ?? '[]', true);

        if (empty($oldFolder) || empty($newFolder) || empty($images)) {
            echo json_encode(['success' => false, 'error' => 'Missing required data']);
            exit;
        }

        $newFolder = preg_replace('/[^a-zA-Z0-9_-]/', '-', strtolower($newFolder));
        $results = ['success' => 0, 'failed' => 0, 'errors' => []];

        foreach ($images as $img) {
            $imageData = @file_get_contents($img['url']);
            if (!$imageData) {
                $results['failed']++;
                continue;
            }

            $newFilename = preg_replace('/^' . preg_quote($oldFolder, '/') . '_/', $newFolder . '_', $img['filename']);

            $tempFile = sys_get_temp_dir() . '/' . uniqid() . '_' . $newFilename;
            file_put_contents($tempFile, $imageData);

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tempFile);
            finfo_close($finfo);

            $uploadData = [
                'file' => new CURLFile($tempFile, $mimeType, $newFilename),
                'metadata' => json_encode(['source' => 'admin'])
            ];

            $uploadResult = cfRequest('POST', '', $uploadData, true);
            unlink($tempFile);

            if ($uploadResult['success'] ?? false) {
                cfRequest('DELETE', '/' . $img['id']);
                $results['success']++;
            } else {
                $results['failed']++;
            }
        }

        echo json_encode([
            'success' => $results['failed'] === 0,
            'message' => "Renamed {$results['success']} images" . ($results['failed'] > 0 ? ", {$results['failed']} failed" : ""),
            'details' => $results
        ]);
        exit;
    }

    if ($action === 'export_zip') {
        $images = json_decode($_POST['images'] ?? '[]', true);
        if (empty($images)) {
            echo json_encode(['success' => false, 'error' => 'No images selected']);
            exit;
        }

        $zipFile = sys_get_temp_dir() . '/images-' . uniqid() . '.zip';
        $zip = new ZipArchive();

        if ($zip->open($zipFile, ZipArchive::CREATE) !== true) {
            echo json_encode(['success' => false, 'error' => 'Could not create ZIP file']);
            exit;
        }

        foreach ($images as $img) {
            $imageData = file_get_contents($img['url']);
            if ($imageData) {
                $filename = $img['filename'] ?? $img['id'] . '.jpg';
                $zip->addFromString($filename, $imageData);
            }
        }

        $zip->close();

        $zipContent = base64_encode(file_get_contents($zipFile));
        unlink($zipFile);

        echo json_encode(['success' => true, 'content' => $zipContent, 'filename' => 'images-' . date('Y-m-d') . '.zip']);
        exit;
    }

    echo json_encode(['success' => false, 'error' => 'Invalid action']);
    exit;
}

// Page setup
$page_title = 'Media Manager';
$extra_head = <<<'CSS'
<style>
/* Page Header */
.media-page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}
.media-page-header h1 { font-size: 1.5rem; color: #000; }
.media-page-header p { color: #666; font-size: 0.875rem; margin-top: 0.25rem; }
.media-page-actions { display: flex; gap: 0.5rem; }

/* Buttons */
.btn-outline {
    background: white;
    border: 1px solid #ddd;
    color: #333;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}
.btn-outline:hover { border-color: #999; background: #f8f9fa; }
.btn-outline svg { width: 16px; height: 16px; }

/* Folder Navigation */
.folder-nav {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
}
.folder-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e9ecef;
}
.breadcrumb-item {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: none;
    border: none;
    color: #666;
    font-size: 0.875rem;
    cursor: pointer;
    padding: 0.35rem 0.75rem;
    border-radius: 4px;
    transition: all 0.2s;
}
.breadcrumb-item:hover { background: #e9ecef; color: #333; }
.breadcrumb-item.active { background: #FDB913; color: #000; font-weight: 500; }
.breadcrumb-item svg { width: 16px; height: 16px; }
.breadcrumb-separator { color: #ccc; }
.folder-list { display: flex; flex-wrap: wrap; gap: 0.5rem; }
.folder-item {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: white;
    border: 1px solid #ddd;
    color: #333;
    font-size: 0.8rem;
    cursor: pointer;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    transition: all 0.2s;
}
.folder-item:hover { border-color: #FDB913; background: #fffbf0; }
.folder-item.active { border-color: #FDB913; background: #FDB913; color: #000; font-weight: 500; }
.folder-item svg { width: 16px; height: 16px; }
.folder-count {
    background: rgba(0,0,0,0.1);
    font-size: 0.7rem;
    padding: 0.15rem 0.4rem;
    border-radius: 10px;
    margin-left: 0.25rem;
}
.folder-item.active .folder-count { background: rgba(0,0,0,0.15); }
.folder-item .folder-edit {
    display: none;
    padding: 0.15rem;
    background: transparent;
    border: none;
    cursor: pointer;
    margin-left: 0.25rem;
    border-radius: 3px;
    color: inherit;
    opacity: 0.6;
}
.folder-item:hover .folder-edit { display: inline-flex; }
.folder-item .folder-edit:hover { opacity: 1; background: rgba(0,0,0,0.1); }
.folder-item .folder-edit svg { width: 12px; height: 12px; }

/* Media Grid */
.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1rem;
}
.media-loading {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    color: #666;
}
.media-item {
    background: #f8f9fa;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
}
.media-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}
.media-item img {
    width: 100%;
    aspect-ratio: 1;
    object-fit: cover;
    display: block;
}
.media-item-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
    padding: 2rem 0.75rem 0.75rem;
    font-size: 0.75rem;
    opacity: 0;
    transition: opacity 0.2s;
}
.media-item:hover .media-item-overlay { opacity: 1; }
.media-item-actions { display: flex; gap: 0.5rem; margin-top: 0.5rem; }
.media-item-actions button {
    flex: 1;
    padding: 0.4rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.7rem;
    font-weight: 600;
}
.btn-copy { background: #FDB913; color: #000; }
.btn-hide { background: #dc3545; color: #fff; }

/* Modals */
.media-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.6);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}
.media-modal.active { display: flex; }
.media-modal-content {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    overflow: hidden;
}
.media-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #eee;
}
.media-modal-header h3 { margin: 0; font-size: 1.1rem; }
.media-modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #999;
}
.media-modal-body { padding: 1.5rem; }

/* Drop Zone */
.drop-zone {
    border: 2px dashed #ccc;
    border-radius: 8px;
    padding: 3rem;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
}
.drop-zone:hover, .drop-zone.dragover {
    border-color: #FDB913;
    background: rgba(253, 185, 19, 0.05);
}
.drop-zone svg { width: 48px; height: 48px; color: #FDB913; margin-bottom: 1rem; }
.drop-zone p { margin: 0; color: #666; }

/* Upload Status */
#uploadStatus { margin-top: 1rem; }
.upload-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0.75rem;
    background: #f8f9fa;
    border-radius: 4px;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}
.upload-item span:first-child {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 70%;
}
.upload-status-text { font-weight: 500; }

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    color: #666;
}
.empty-state svg { width: 64px; height: 64px; color: #ccc; margin-bottom: 1rem; }

/* Bulk Toolbar */
.bulk-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 0.5rem;
}
.bulk-toolbar-left, .bulk-toolbar-right {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}
.bulk-count { color: #666; font-size: 0.875rem; margin-left: 0.5rem; }

/* Selection Mode */
.media-grid.select-mode .media-item { cursor: pointer; }
.media-item .select-checkbox {
    display: none;
    position: absolute;
    top: 8px;
    left: 8px;
    width: 24px;
    height: 24px;
    background: white;
    border: 2px solid #ccc;
    border-radius: 4px;
    z-index: 10;
    align-items: center;
    justify-content: center;
}
.media-grid.select-mode .media-item .select-checkbox { display: flex; }
.media-item.selected .select-checkbox { background: #FDB913; border-color: #FDB913; }
.media-item.selected .select-checkbox::after { content: '\2713'; color: #000; font-weight: bold; font-size: 14px; }
.media-item.selected { outline: 3px solid #FDB913; }
.media-grid.select-mode .media-item .media-item-overlay { display: none; }

/* Preview Modal */
.preview-modal-content {
    background: #111;
    border-radius: 12px;
    width: 95%;
    max-width: 900px;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    position: relative;
}
.preview-modal-close {
    position: absolute;
    top: 10px;
    right: 14px;
    background: rgba(0,0,0,0.5);
    border: none;
    color: #fff;
    font-size: 1.75rem;
    cursor: pointer;
    z-index: 10;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
    transition: background 0.2s;
}
.preview-modal-close:hover { background: rgba(255,255,255,0.2); }
.preview-modal-image {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
    min-height: 0;
    overflow: hidden;
}
.preview-modal-image img {
    max-width: 100%;
    max-height: 70vh;
    object-fit: contain;
    border-radius: 4px;
}
.preview-modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1.5rem;
    background: #1a1a1a;
    border-top: 1px solid #333;
    flex-wrap: wrap;
    gap: 0.5rem;
}
.preview-filename {
    color: #aaa;
    font-size: 0.85rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 50%;
}
.preview-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }
.preview-actions .btn-outline {
    color: #ccc;
    border-color: #555;
    font-size: 0.8rem;
    padding: 0.35rem 0.75rem;
}
.preview-actions .btn-outline:hover {
    color: #fff;
    border-color: #888;
    background: rgba(255,255,255,0.1);
}
.preview-actions .btn-danger-outline:hover {
    border-color: #dc3545;
    color: #dc3545;
    background: rgba(220,53,69,0.1);
}
.preview-actions .btn-outline svg { width: 14px; height: 14px; }

/* Total Count */
.load-more-container {
    grid-column: 1 / -1;
    text-align: center;
    padding: 2rem 1rem;
    border-top: 1px solid #eee;
    margin-top: 1rem;
}
.load-more-count { color: #999; font-size: 0.85rem; }

/* Rename warning */
.rename-warning {
    background: #fff3cd;
    border: 1px solid #ffc107;
    padding: 0.75rem;
    border-radius: 4px;
    margin-top: 1rem;
    font-size: 0.85rem;
}

/* Responsive */
@media (max-width: 768px) {
    .media-page-header { flex-direction: column; gap: 1rem; align-items: flex-start; }
    .media-grid { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); }
    .bulk-toolbar { flex-direction: column; align-items: flex-start; }
    .preview-modal-footer { flex-direction: column; }
    .preview-filename { max-width: 100%; }
}
</style>
CSS;

include __DIR__ . '/includes/admin-header.php';
?>

<!-- Page Header -->
<div class="media-page-header">
    <div>
        <h1>Media Manager</h1>
        <p>Manage your images on Cloudflare</p>
    </div>
    <div class="media-page-actions">
        <button type="button" class="btn-outline" id="newFolderBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
            New Folder
        </button>
        <button type="button" class="btn-outline" id="selectModeBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            Select
        </button>
        <button type="button" class="btn btn-primary" id="uploadBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            Upload Image
        </button>
    </div>
</div>

<!-- Bulk Actions Toolbar -->
<div id="bulkToolbar" class="bulk-toolbar" style="display: none;">
    <div class="bulk-toolbar-left">
        <button type="button" class="btn btn-sm btn-secondary" id="selectAllBtn">Select All</button>
        <button type="button" class="btn btn-sm btn-secondary" id="deselectAllBtn">Deselect All</button>
        <span class="bulk-count"><span id="selectedCount">0</span> selected</span>
    </div>
    <div class="bulk-toolbar-right">
        <button type="button" class="btn btn-sm btn-outline" id="moveImagesBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
            Move to Folder
        </button>
        <button type="button" class="btn btn-sm btn-outline" id="exportLinksBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            Export Links
        </button>
        <button type="button" class="btn btn-sm btn-outline" id="exportZipBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Export ZIP
        </button>
        <button type="button" class="btn btn-sm btn-secondary" id="cancelSelectBtn">Cancel</button>
    </div>
</div>

<!-- Folder Navigation -->
<div class="folder-nav">
    <div class="folder-breadcrumb">
        <button type="button" class="breadcrumb-item active" data-folder="">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            All Images
        </button>
    </div>
    <div class="folder-list" id="folderList"></div>
</div>

<!-- Image Grid -->
<div class="card">
    <div class="card-body">
        <div id="imageGrid" class="media-grid">
            <div class="media-loading">Loading images...</div>
        </div>
    </div>
</div>

<!-- New Folder Modal -->
<div id="folderModal" class="media-modal">
    <div class="media-modal-content" style="max-width: 400px;">
        <div class="media-modal-header">
            <h3>Create New Folder</h3>
            <button type="button" class="media-modal-close" id="closeFolderModal">&times;</button>
        </div>
        <div class="media-modal-body">
            <div class="form-group">
                <label for="folderName">Folder Name</label>
                <input type="text" id="folderName" style="width:100%;padding:0.75rem;border:1px solid #ddd;border-radius:4px;font-size:1rem;" placeholder="e.g., gallery, projects, team">
                <small style="display:block;margin-top:0.25rem;color:#666;font-size:0.75rem;">Letters, numbers, hyphens and underscores only</small>
            </div>
            <button type="button" class="btn btn-primary" id="createFolderBtn" style="width: 100%; margin-top: 1rem;">Create Folder</button>
        </div>
    </div>
</div>

<!-- Move Images Modal -->
<div id="moveImagesModal" class="media-modal">
    <div class="media-modal-content" style="max-width: 400px;">
        <div class="media-modal-header">
            <h3>Move Images to Folder</h3>
            <button type="button" class="media-modal-close" id="closeMoveModal">&times;</button>
        </div>
        <div class="media-modal-body">
            <p style="margin-bottom: 1rem; color: #666;"><span id="moveImageCount">0</span> images selected</p>
            <div class="form-group">
                <label for="targetFolder">Destination Folder</label>
                <select id="targetFolder" style="width:100%;padding:0.75rem;border:1px solid #ddd;border-radius:4px;font-size:1rem;">
                    <option value="">(Root - No Folder)</option>
                </select>
            </div>
            <div style="margin: 1rem 0; text-align: center; color: #999;">&mdash; or &mdash;</div>
            <div class="form-group">
                <label for="newTargetFolder">Create New Folder</label>
                <input type="text" id="newTargetFolder" style="width:100%;padding:0.75rem;border:1px solid #ddd;border-radius:4px;font-size:1rem;" placeholder="Enter new folder name">
                <small style="display:block;margin-top:0.25rem;color:#666;font-size:0.75rem;">Leave empty to use selection above</small>
            </div>
            <button type="button" class="btn btn-primary" id="confirmMoveBtn" style="width: 100%; margin-top: 1rem;">Move Images</button>
        </div>
    </div>
</div>

<!-- Rename Folder Modal -->
<div id="renameFolderModal" class="media-modal">
    <div class="media-modal-content" style="max-width: 400px;">
        <div class="media-modal-header">
            <h3>Rename Folder</h3>
            <button type="button" class="media-modal-close" id="closeRenameFolderModal">&times;</button>
        </div>
        <div class="media-modal-body">
            <div class="form-group">
                <label>Current Name</label>
                <input type="text" id="oldFolderName" readonly style="width:100%;padding:0.75rem;border:1px solid #ddd;border-radius:4px;font-size:1rem;background:#f5f5f5;">
            </div>
            <div class="form-group" style="margin-top: 1rem;">
                <label for="newFolderName">New Name</label>
                <input type="text" id="newFolderName" style="width:100%;padding:0.75rem;border:1px solid #ddd;border-radius:4px;font-size:1rem;" placeholder="Enter new folder name">
                <small style="display:block;margin-top:0.25rem;color:#666;font-size:0.75rem;">Letters, numbers, hyphens and underscores only</small>
            </div>
            <div class="rename-warning">
                <strong>Note:</strong> This will re-upload all images in this folder with the new name. This may take a moment for folders with many images.
            </div>
            <button type="button" class="btn btn-primary" id="renameFolderBtn" style="width: 100%; margin-top: 1rem;">Rename Folder</button>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div id="previewModal" class="media-modal">
    <div class="preview-modal-content">
        <button type="button" class="preview-modal-close" id="closePreviewModal">&times;</button>
        <div class="preview-modal-image">
            <img id="previewImage" src="" alt="">
        </div>
        <div class="preview-modal-footer">
            <span class="preview-filename" id="previewFilename"></span>
            <div class="preview-actions">
                <a id="previewDownload" class="btn-outline" download style="text-decoration:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download
                </a>
                <button type="button" class="btn-outline" id="previewCopyUrl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    Copy URL
                </button>
                <button type="button" class="btn-outline" id="previewHide">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    Hide
                </button>
                <button type="button" class="btn-outline btn-danger-outline" id="previewDelete">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="media-modal">
    <div class="media-modal-content">
        <div class="media-modal-header">
            <h3>Upload Images</h3>
            <button type="button" class="media-modal-close" id="closeUploadModal">&times;</button>
        </div>
        <div class="media-modal-body">
            <div id="uploadFolderNote"></div>
            <div id="dropZone" class="drop-zone">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p>Drop images here or click to browse</p>
                <input type="file" id="fileInput" accept="image/*" multiple hidden>
            </div>
            <div id="uploadStatus"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const grid = document.getElementById('imageGrid');
    const uploadModal = document.getElementById('uploadModal');
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const uploadStatus = document.getElementById('uploadStatus');

    let allImages = [];
    let selectMode = false;
    let currentFolder = '';
    let folders = new Set();
    let isLoading = false;

    // Hidden images (localStorage)
    const HIDDEN_KEY = 'gq_hidden_media';
    function loadHidden() {
        try { const s = localStorage.getItem(HIDDEN_KEY); return s ? new Set(JSON.parse(s)) : new Set(); } catch(e) { return new Set(); }
    }
    function saveHidden(s) {
        try { localStorage.setItem(HIDDEN_KEY, JSON.stringify(Array.from(s))); } catch(e) {}
    }
    let hiddenImages = loadHidden();

    // Custom folders (localStorage)
    const FOLDERS_KEY = 'gq_media_folders';
    function loadCustomFolders() {
        try { const s = localStorage.getItem(FOLDERS_KEY); return s ? new Set(JSON.parse(s)) : new Set(); } catch(e) { return new Set(); }
    }
    function saveCustomFolders(s) {
        try { localStorage.setItem(FOLDERS_KEY, JSON.stringify(Array.from(s))); } catch(e) {}
    }
    let customFolders = loadCustomFolders();

    // Load images
    loadImages();

    // Upload button
    document.getElementById('uploadBtn').onclick = function() {
        uploadModal.classList.add('active');
        uploadStatus.innerHTML = '';
        const note = currentFolder ? `<p style="text-align:center;color:#666;font-size:0.85rem;margin-bottom:1rem;">Uploading to: <strong>${currentFolder}</strong></p>` : '';
        document.getElementById('uploadFolderNote').innerHTML = note;
    };

    // New folder button
    document.getElementById('newFolderBtn').onclick = function() {
        document.getElementById('folderModal').classList.add('active');
        document.getElementById('folderName').value = '';
        document.getElementById('folderName').focus();
    };

    // Close modals
    document.getElementById('closeFolderModal').onclick = function() { document.getElementById('folderModal').classList.remove('active'); };
    document.getElementById('closeUploadModal').onclick = function() { uploadModal.classList.remove('active'); };
    document.getElementById('closeMoveModal').onclick = function() { document.getElementById('moveImagesModal').classList.remove('active'); };
    document.getElementById('closeRenameFolderModal').onclick = function() { document.getElementById('renameFolderModal').classList.remove('active'); };

    // Click outside modal closes it
    document.querySelectorAll('.media-modal').forEach(function(m) {
        m.addEventListener('click', function(e) { if (e.target === this) this.classList.remove('active'); });
    });

    // Create folder
    document.getElementById('createFolderBtn').onclick = function() {
        const name = document.getElementById('folderName').value.trim().toLowerCase().replace(/[^a-z0-9_-]/g, '-');
        if (!name) { alert('Please enter a folder name'); return; }
        folders.add(name);
        customFolders.add(name);
        saveCustomFolders(customFolders);
        currentFolder = name;
        buildFolderList(allImages);
        renderFilteredImages();
        document.getElementById('folderModal').classList.remove('active');
    };

    // Rename folder
    function openRenameFolderModal(folderName) {
        document.getElementById('oldFolderName').value = folderName;
        document.getElementById('newFolderName').value = folderName;
        document.getElementById('renameFolderModal').classList.add('active');
        document.getElementById('newFolderName').focus();
        document.getElementById('newFolderName').select();
    }

    document.getElementById('renameFolderBtn').onclick = function() {
        const oldName = document.getElementById('oldFolderName').value;
        const newName = document.getElementById('newFolderName').value.trim().toLowerCase().replace(/[^a-z0-9_-]/g, '-');
        if (!newName) { alert('Please enter a new folder name'); return; }
        if (newName === oldName) { document.getElementById('renameFolderModal').classList.remove('active'); return; }

        const folderImages = allImages.filter(img => getFolderFromFilename(img.filename) === oldName);
        if (folderImages.length === 0) { alert('No images found in this folder'); return; }

        const btn = this;
        btn.disabled = true;
        btn.textContent = 'Renaming ' + folderImages.length + ' images...';

        fetch(window.location.href, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'action=rename_folder&old_folder=' + encodeURIComponent(oldName) + '&new_folder=' + encodeURIComponent(newName) + '&images=' + encodeURIComponent(JSON.stringify(folderImages))
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { currentFolder = newName; loadImages(); document.getElementById('renameFolderModal').classList.remove('active'); }
            alert(data.message || (data.success ? 'Folder renamed' : 'Failed'));
        })
        .catch(err => alert('Error: ' + err.message))
        .finally(() => { btn.disabled = false; btn.textContent = 'Rename Folder'; });
    };

    // Drop zone
    dropZone.onclick = function() { fileInput.click(); };
    dropZone.ondragover = function(e) { e.preventDefault(); dropZone.classList.add('dragover'); };
    dropZone.ondragleave = function() { dropZone.classList.remove('dragover'); };
    dropZone.ondrop = function(e) {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        if (e.dataTransfer.files.length) uploadFiles(Array.from(e.dataTransfer.files));
    };
    fileInput.onchange = function() { if (fileInput.files.length) uploadFiles(Array.from(fileInput.files)); };

    // Load images from Cloudflare
    function loadImages() {
        if (isLoading) return;
        isLoading = true;
        grid.innerHTML = '<div class="media-loading">Loading images...</div>';

        fetch(window.location.href, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'action=list'
        })
        .then(r => r.json())
        .then(data => {
            isLoading = false;
            if (data.success && data.images) {
                allImages = data.images.filter(img => !hiddenImages.has(img.id));
                if (allImages.length === 0) {
                    grid.innerHTML = '<div class="empty-state"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><p>No images yet.<br>Click Upload to add your first image.</p></div>';
                } else {
                    renderImages(allImages);
                }
            } else {
                grid.innerHTML = '<div class="media-loading">Error: ' + (data.error || 'Failed to load') + '</div>';
            }
        })
        .catch(err => { isLoading = false; grid.innerHTML = '<div class="media-loading">Error: ' + err.message + '</div>'; });
    }

    function getFolderFromFilename(filename) {
        const match = filename.match(/^([a-zA-Z0-9-]+)_/);
        return match ? match[1] : '';
    }

    function buildFolderList(images) {
        folders = new Set();
        const folderCounts = {};

        images.forEach(img => {
            const folder = getFolderFromFilename(img.filename);
            if (folder) { folders.add(folder); folderCounts[folder] = (folderCounts[folder] || 0) + 1; }
        });

        customFolders.forEach(folder => { folders.add(folder); if (!folderCounts[folder]) folderCounts[folder] = 0; });

        const folderList = document.getElementById('folderList');
        const sorted = Array.from(folders).sort();

        folderList.innerHTML = sorted.map(folder =>
            '<button type="button" class="folder-item ' + (currentFolder === folder ? 'active' : '') + '" data-folder="' + folder + '">' +
            '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>' +
            folder +
            '<span class="folder-count">' + (folderCounts[folder] || 0) + '</span>' +
            '<span class="folder-edit" data-rename="' + folder + '" title="Rename folder"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg></span>' +
            '</button>'
        ).join('');

        updateBreadcrumb();

        folderList.querySelectorAll('.folder-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (e.target.closest('.folder-edit')) {
                    e.stopPropagation();
                    openRenameFolderModal(e.target.closest('.folder-edit').dataset.rename);
                    return;
                }
                currentFolder = this.dataset.folder;
                renderFilteredImages();
                buildFolderList(allImages);
            });
        });
    }

    function updateBreadcrumb() {
        const bc = document.querySelector('.folder-breadcrumb');
        const homeIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>';
        const folderIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>';

        if (currentFolder) {
            bc.innerHTML = '<button type="button" class="breadcrumb-item" data-folder="">' + homeIcon + ' All Images</button>' +
                '<span class="breadcrumb-separator">/</span>' +
                '<button type="button" class="breadcrumb-item active" data-folder="' + currentFolder + '">' + folderIcon + ' ' + currentFolder + '</button>';
        } else {
            bc.innerHTML = '<button type="button" class="breadcrumb-item active" data-folder="">' + homeIcon + ' All Images</button>';
        }

        bc.querySelectorAll('.breadcrumb-item').forEach(item => {
            item.addEventListener('click', function() {
                currentFolder = this.dataset.folder;
                renderFilteredImages();
                buildFolderList(allImages);
            });
        });
    }

    function renderFilteredImages() {
        const filtered = currentFolder ? allImages.filter(img => getFolderFromFilename(img.filename) === currentFolder) : allImages;
        renderImagesToGrid(filtered);
    }

    function renderImages(images) {
        allImages = images;
        buildFolderList(images);
        renderFilteredImages();
    }

    function renderImagesToGrid(images) {
        if (images.length === 0) {
            grid.innerHTML = '<div class="empty-state"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" width="64" height="64"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><p>No images' + (currentFolder ? ' in this folder' : '') + '.<br>Click Upload to add images.</p></div>';
            return;
        }

        let html = images.map(img =>
            '<div class="media-item" data-id="' + img.id + '" data-url="' + img.url + '" data-filename="' + img.filename + '">' +
            '<div class="select-checkbox"></div>' +
            '<img src="' + img.url + '" alt="' + img.filename + '" loading="lazy">' +
            '<div class="media-item-overlay">' +
            '<div>' + img.filename + '</div>' +
            '<div class="media-item-actions">' +
            '<button class="btn-copy" onclick="event.stopPropagation(); copyUrl(\'' + img.url + '\')">Copy URL</button>' +
            '<button class="btn-hide" onclick="event.stopPropagation(); hideImage(\'' + img.id + '\')">Hide</button>' +
            '</div></div></div>'
        ).join('');

        if (!currentFolder) {
            html += '<div class="load-more-container"><p class="load-more-count">' + images.length + ' total images</p></div>';
        }

        grid.innerHTML = html;

        document.querySelectorAll('.media-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (selectMode) {
                    e.preventDefault();
                    this.classList.toggle('selected');
                    updateSelectedCount();
                } else if (!e.target.closest('.media-item-actions')) {
                    openPreview(this.dataset.url, this.dataset.filename, this.dataset.id);
                }
            });
        });
    }

    // Select mode
    document.getElementById('selectModeBtn').onclick = function() {
        selectMode = true;
        grid.classList.add('select-mode');
        document.getElementById('bulkToolbar').style.display = 'flex';
        this.style.display = 'none';
    };

    document.getElementById('cancelSelectBtn').onclick = exitSelectMode;

    function exitSelectMode() {
        selectMode = false;
        grid.classList.remove('select-mode');
        document.getElementById('bulkToolbar').style.display = 'none';
        document.getElementById('selectModeBtn').style.display = '';
        document.querySelectorAll('.media-item.selected').forEach(el => el.classList.remove('selected'));
        updateSelectedCount();
    }

    document.getElementById('selectAllBtn').onclick = function() {
        document.querySelectorAll('.media-item').forEach(el => el.classList.add('selected'));
        updateSelectedCount();
    };

    document.getElementById('deselectAllBtn').onclick = function() {
        document.querySelectorAll('.media-item.selected').forEach(el => el.classList.remove('selected'));
        updateSelectedCount();
    };

    function updateSelectedCount() {
        document.getElementById('selectedCount').textContent = document.querySelectorAll('.media-item.selected').length;
    }

    // Move images
    document.getElementById('moveImagesBtn').onclick = function() {
        const selected = document.querySelectorAll('.media-item.selected');
        if (selected.length === 0) { alert('Please select at least one image'); return; }
        document.getElementById('moveImageCount').textContent = selected.length;
        const sel = document.getElementById('targetFolder');
        sel.innerHTML = '<option value="">(Root - No Folder)</option>';
        Array.from(folders).sort().forEach(f => { sel.innerHTML += '<option value="' + f + '">' + f + '</option>'; });
        document.getElementById('newTargetFolder').value = '';
        document.getElementById('moveImagesModal').classList.add('active');
    };

    document.getElementById('confirmMoveBtn').onclick = function() {
        let target = document.getElementById('newTargetFolder').value.trim().toLowerCase().replace(/[^a-z0-9_-]/g, '-');
        if (!target) target = document.getElementById('targetFolder').value;

        const selected = document.querySelectorAll('.media-item.selected');
        const images = Array.from(selected).map(el => ({ id: el.dataset.id, url: el.dataset.url, filename: el.dataset.filename }));

        const btn = this;
        btn.disabled = true;
        btn.textContent = 'Moving ' + images.length + ' images...';

        fetch(window.location.href, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'action=move_images&target_folder=' + encodeURIComponent(target) + '&images=' + encodeURIComponent(JSON.stringify(images))
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { currentFolder = target; loadImages(); exitSelectMode(); document.getElementById('moveImagesModal').classList.remove('active'); }
            alert(data.message || (data.success ? 'Moved!' : 'Failed'));
        })
        .catch(err => alert('Error: ' + err.message))
        .finally(() => { btn.disabled = false; btn.textContent = 'Move Images'; });
    };

    // Export links
    document.getElementById('exportLinksBtn').onclick = function() {
        const selected = document.querySelectorAll('.media-item.selected');
        if (selected.length === 0) { alert('Please select at least one image'); return; }
        const images = Array.from(selected).map(el => ({ filename: el.dataset.filename, url: el.dataset.url }));

        fetch(window.location.href, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'action=export_links&images=' + encodeURIComponent(JSON.stringify(images))
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { downloadTextFile(data.content, data.filename); exitSelectMode(); }
            else alert(data.error || 'Export failed');
        });
    };

    // Export ZIP
    document.getElementById('exportZipBtn').onclick = function() {
        const selected = document.querySelectorAll('.media-item.selected');
        if (selected.length === 0) { alert('Please select at least one image'); return; }
        const images = Array.from(selected).map(el => ({ id: el.dataset.id, url: el.dataset.url, filename: el.dataset.filename }));

        this.disabled = true;
        this.textContent = 'Creating ZIP...';

        fetch(window.location.href, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'action=export_zip&images=' + encodeURIComponent(JSON.stringify(images))
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { downloadBase64File(data.content, data.filename, 'application/zip'); exitSelectMode(); }
            else alert(data.error || 'Export failed');
        })
        .finally(() => { this.disabled = false; this.textContent = 'Export ZIP'; });
    };

    function downloadTextFile(content, filename) {
        const blob = new Blob([content], {type: 'text/plain'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a'); a.href = url; a.download = filename; a.click();
        URL.revokeObjectURL(url);
    }

    function downloadBase64File(base64, filename, mimeType) {
        const byteChars = atob(base64);
        const byteNumbers = new Array(byteChars.length);
        for (let i = 0; i < byteChars.length; i++) byteNumbers[i] = byteChars.charCodeAt(i);
        const blob = new Blob([new Uint8Array(byteNumbers)], {type: mimeType});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a'); a.href = url; a.download = filename; a.click();
        URL.revokeObjectURL(url);
    }

    // Upload files
    function uploadFiles(files) {
        const imageFiles = files.filter(f => f.type.startsWith('image/'));
        if (imageFiles.length === 0) { uploadStatus.innerHTML = '<div style="color:#dc3545;padding:0.5rem;background:#f8d7da;border-radius:4px;">Please select image files</div>'; return; }

        uploadStatus.innerHTML = imageFiles.map((f, i) =>
            '<div class="upload-item" id="upload-' + i + '"><span>' + f.name + '</span><span class="upload-status-text">Waiting...</span></div>'
        ).join('');

        let completed = 0;
        imageFiles.forEach((file, index) => {
            uploadSingleFile(file, index, () => {
                completed++;
                if (completed === imageFiles.length) {
                    fileInput.value = '';
                    loadImages();
                    setTimeout(() => { uploadModal.classList.remove('active'); }, 1500);
                }
            });
        });
    }

    function uploadSingleFile(file, index, onComplete) {
        const statusEl = document.querySelector('#upload-' + index + ' .upload-status-text');
        statusEl.textContent = 'Uploading...';
        statusEl.style.color = '#666';

        let filename = file.name;
        if (currentFolder && !filename.startsWith(currentFolder + '_')) {
            filename = currentFolder + '_' + filename;
        }

        const renamedFile = new File([file], filename, { type: file.type });
        const formData = new FormData();
        formData.append('action', 'upload');
        formData.append('image', renamedFile);

        fetch(window.location.href, { method: 'POST', body: formData })
        .then(r => r.json())
        .then(data => {
            if (data.success) { statusEl.textContent = 'Done!'; statusEl.style.color = '#28a745'; }
            else { statusEl.textContent = data.error || 'Failed'; statusEl.style.color = '#dc3545'; }
            onComplete();
        })
        .catch(() => { statusEl.textContent = 'Error'; statusEl.style.color = '#dc3545'; onComplete(); });
    }

    // Global functions
    window.copyUrl = function(url) {
        navigator.clipboard.writeText(url).then(() => alert('URL copied!')).catch(() => prompt('Copy this URL:', url));
    };

    window.hideImage = function(id) {
        hiddenImages.add(id);
        saveHidden(hiddenImages);
        allImages = allImages.filter(img => img.id !== id);
        buildFolderList(allImages);
        renderFilteredImages();
    };

    // Preview modal
    let currentPreviewId = '', currentPreviewUrl = '';
    const previewModal = document.getElementById('previewModal');

    function openPreview(url, filename, id) {
        currentPreviewId = id;
        currentPreviewUrl = url;
        document.getElementById('previewImage').src = url;
        document.getElementById('previewImage').alt = filename;
        document.getElementById('previewFilename').textContent = filename;
        document.getElementById('previewDownload').href = url;
        document.getElementById('previewDownload').download = filename;
        previewModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closePreview() {
        previewModal.classList.remove('active');
        document.body.style.overflow = '';
        document.getElementById('previewImage').src = '';
    }

    document.getElementById('closePreviewModal').onclick = closePreview;
    document.addEventListener('keydown', function(e) { if (e.key === 'Escape' && previewModal.classList.contains('active')) closePreview(); });

    document.getElementById('previewCopyUrl').onclick = function() {
        const btn = this;
        navigator.clipboard.writeText(currentPreviewUrl).then(() => {
            btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Copied!';
            setTimeout(() => {
                btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg> Copy URL';
            }, 2000);
        }).catch(() => prompt('Copy this URL:', currentPreviewUrl));
    };

    document.getElementById('previewHide').onclick = function() {
        hiddenImages.add(currentPreviewId);
        saveHidden(hiddenImages);
        allImages = allImages.filter(img => img.id !== currentPreviewId);
        closePreview();
        buildFolderList(allImages);
        renderFilteredImages();
    };

    document.getElementById('previewDelete').onclick = function() {
        if (!confirm('Permanently delete this image from Cloudflare? This cannot be undone.')) return;
        const idToDelete = currentPreviewId;

        fetch(window.location.href, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'action=delete&image_id=' + idToDelete
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                hiddenImages.delete(idToDelete);
                saveHidden(hiddenImages);
                closePreview();
                loadImages();
            } else {
                alert('Failed to delete image');
            }
        });
    };
});
</script>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
