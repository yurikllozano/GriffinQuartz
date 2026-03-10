<?php
/**
 * Griffin Quartz - Blog Migration Script
 * Imports all static blog PHP files into the database
 * Run once from admin panel, then can be deleted
 */

require_once __DIR__ . '/includes/admin-auth.php';

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    // Show login form
    ?>
    <!DOCTYPE html>
    <html><head><title>Blog Migration - Login</title></head>
    <body style="font-family:sans-serif;max-width:400px;margin:50px auto;">
        <h2>Admin Login Required</h2>
        <?php if (isset($auth_error)): ?><p style="color:red;"><?= $auth_error ?></p><?php endif; ?>
        <form method="post"><input type="password" name="admin_password" placeholder="Admin password" style="padding:8px;width:100%;"><br><br>
        <button type="submit" style="padding:8px 16px;">Login</button></form>
    </body></html>
    <?php
    exit();
}

// Only run on POST to prevent accidental execution
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_GET['run'])) {
    ?>
    <!DOCTYPE html>
    <html><head><title>Blog Migration</title>
    <style>body{font-family:sans-serif;max-width:800px;margin:30px auto;padding:0 20px;} .btn{padding:12px 24px;background:#FDB913;border:none;cursor:pointer;font-size:16px;border-radius:4px;} .btn:hover{background:#e5a711;}</style>
    </head><body>
        <h1>Blog Migration: Static Files &rarr; Database</h1>
        <p>This will scan all static blog PHP files in <code>/blog/</code> and import them into the database.</p>
        <p><strong>Existing posts with matching slugs will be skipped</strong> (no duplicates).</p>
        <form method="post">
            <button type="submit" class="btn">Run Migration</button>
        </form>
        <br><a href="/admin/">&larr; Back to Admin</a>
    </body></html>
    <?php
    exit();
}

// --- Run Migration ---

require_once dirname(__DIR__) . '/api/config.php';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_BLOG_HOST . ";dbname=" . DB_BLOG_NAME . ";charset=utf8mb4",
        DB_BLOG_USER,
        DB_BLOG_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    die("<h2>Database connection failed:</h2><pre>" . htmlspecialchars($e->getMessage()) . "</pre>");
}

$blogDir = dirname(__DIR__) . '/blog';
$skipFiles = ['index.php', 'index-static.php', 'post.php', 'BLOG-STRATEGY-2026.md'];
$results = [];
$imported = 0;
$skipped = 0;
$errors = 0;

// Get existing slugs to avoid duplicates
$existingSlugs = $pdo->query("SELECT slug FROM blog_posts")->fetchAll(PDO::FETCH_COLUMN);

// Scan blog directory for PHP files
$files = glob($blogDir . '/*.php');
sort($files);

foreach ($files as $filePath) {
    $filename = basename($filePath);

    // Skip non-blog files
    if (in_array($filename, $skipFiles)) continue;

    $slug = str_replace('.php', '', $filename);

    // Skip if already in database
    if (in_array($slug, $existingSlugs)) {
        $results[] = ['slug' => $slug, 'status' => 'SKIPPED', 'msg' => 'Already exists in database'];
        $skipped++;
        continue;
    }

    try {
        $html = file_get_contents($filePath);
        $data = parseStaticBlog($html, $slug);

        if (!$data['title']) {
            $results[] = ['slug' => $slug, 'status' => 'ERROR', 'msg' => 'Could not extract title'];
            $errors++;
            continue;
        }

        // Insert into blog_posts
        $stmt = $pdo->prepare("INSERT INTO blog_posts
            (title, slug, content, excerpt, featured_image, featured_image_alt,
             status, publish_date, seo_title, seo_description, seo_keywords,
             og_title, og_description, og_image, author)
            VALUES (?, ?, ?, ?, ?, ?, 'published', ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $data['title'],
            $slug,
            $data['content'],
            $data['excerpt'],
            $data['featured_image'],
            $data['featured_image_alt'],
            $data['publish_date'],
            $data['seo_title'],
            $data['seo_description'],
            $data['seo_keywords'],
            $data['og_title'],
            $data['og_description'],
            $data['og_image'],
            $data['author']
        ]);

        $postId = $pdo->lastInsertId();

        // Insert FAQs if any
        $faqCount = 0;
        if (!empty($data['faqs'])) {
            $faqStmt = $pdo->prepare("INSERT INTO blog_faqs (post_id, question, answer, sort_order) VALUES (?, ?, ?, ?)");
            foreach ($data['faqs'] as $i => $faq) {
                $faqStmt->execute([$postId, $faq['question'], $faq['answer'], $i]);
                $faqCount++;
            }
        }

        $results[] = ['slug' => $slug, 'status' => 'IMPORTED', 'msg' => "ID: $postId" . ($faqCount ? ", $faqCount FAQs" : "")];
        $imported++;

    } catch (Exception $e) {
        $results[] = ['slug' => $slug, 'status' => 'ERROR', 'msg' => $e->getMessage()];
        $errors++;
    }
}

// --- Output Results ---
?>
<!DOCTYPE html>
<html><head><title>Blog Migration Results</title>
<style>
body{font-family:sans-serif;max-width:900px;margin:30px auto;padding:0 20px;}
table{width:100%;border-collapse:collapse;margin:20px 0;}
th,td{padding:8px 12px;text-align:left;border-bottom:1px solid #ddd;}
th{background:#f5f5f5;}
.IMPORTED{color:green;font-weight:bold;}
.SKIPPED{color:#666;}
.ERROR{color:red;font-weight:bold;}
.summary{background:#f9f9f9;padding:20px;border-radius:8px;margin:20px 0;}
</style>
</head><body>
<h1>Migration Complete</h1>
<div class="summary">
    <p><strong>Imported:</strong> <?= $imported ?> | <strong>Skipped:</strong> <?= $skipped ?> | <strong>Errors:</strong> <?= $errors ?> | <strong>Total files:</strong> <?= count($results) ?></p>
</div>

<table>
<tr><th>Slug</th><th>Status</th><th>Details</th></tr>
<?php foreach ($results as $r): ?>
<tr>
    <td><?= htmlspecialchars($r['slug']) ?></td>
    <td class="<?= $r['status'] ?>"><?= $r['status'] ?></td>
    <td><?= htmlspecialchars($r['msg']) ?></td>
</tr>
<?php endforeach; ?>
</table>

<br><a href="/admin/">&larr; Back to Admin</a>
</body></html>
<?php

// =====================================================
// Parser Functions
// =====================================================

function parseStaticBlog($html, $slug) {
    $data = [
        'title' => '',
        'content' => '',
        'excerpt' => '',
        'featured_image' => '',
        'featured_image_alt' => '',
        'publish_date' => null,
        'seo_title' => '',
        'seo_description' => '',
        'seo_keywords' => '',
        'og_title' => '',
        'og_description' => '',
        'og_image' => '',
        'author' => 'Griffin Quartz Team',
        'faqs' => []
    ];

    // Suppress DOMDocument warnings for PHP tags in HTML
    libxml_use_internal_errors(true);

    $doc = new DOMDocument();
    $doc->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    libxml_clear_errors();

    $xpath = new DOMXPath($doc);

    // --- Extract from <title> tag ---
    $titleNodes = $doc->getElementsByTagName('title');
    if ($titleNodes->length > 0) {
        $fullTitle = $titleNodes->item(0)->textContent;
        // Remove " | Griffin Quartz" suffix
        $data['seo_title'] = trim($fullTitle);
        $data['title'] = trim(preg_replace('/\s*\|.*$/', '', $fullTitle));
    }

    // --- Extract <meta> tags ---
    $metas = $doc->getElementsByTagName('meta');
    foreach ($metas as $meta) {
        $name = $meta->getAttribute('name');
        $property = $meta->getAttribute('property');
        $content = $meta->getAttribute('content');

        switch ($name) {
            case 'description':
                $data['excerpt'] = $content;
                $data['seo_description'] = $content;
                break;
            case 'keywords':
                $data['seo_keywords'] = $content;
                break;
        }

        switch ($property) {
            case 'og:title':
                $data['og_title'] = $content;
                break;
            case 'og:description':
                $data['og_description'] = $content;
                break;
            case 'og:image':
                $data['og_image'] = $content;
                break;
            case 'article:published_time':
                $data['publish_date'] = date('Y-m-d H:i:s', strtotime($content));
                break;
        }
    }

    // --- Extract H1 (true title) ---
    $h1s = $doc->getElementsByTagName('h1');
    if ($h1s->length > 0) {
        $h1Title = trim($h1s->item(0)->textContent);
        if ($h1Title) {
            $data['title'] = $h1Title;
        }
    }

    // --- Extract featured image from blog-hero-image class ---
    $imgs = $doc->getElementsByTagName('img');
    foreach ($imgs as $img) {
        $class = $img->getAttribute('class');
        if (strpos($class, 'blog-hero-image') !== false) {
            $src = $img->getAttribute('src');
            // Normalize relative paths to absolute
            $src = str_replace('../images/', '/images/', $src);
            $data['featured_image'] = $src;
            $data['featured_image_alt'] = $img->getAttribute('alt');
            break;
        }
    }

    // --- Extract author from blog-meta span ---
    $spans = $xpath->query("//*[contains(@class, 'blog-meta')]");
    if ($spans->length > 0) {
        $metaText = $spans->item(0)->textContent;
        // Pattern: "By Author Name | Date" or "By Author Name • Date"
        if (preg_match('/By\s+(.+?)(?:\s*[\|•·]\s*)(.+)/i', $metaText, $m)) {
            $data['author'] = trim($m[1]);
            // Try to parse date
            $dateStr = trim($m[2]);
            $ts = strtotime($dateStr);
            if ($ts && !$data['publish_date']) {
                $data['publish_date'] = date('Y-m-d H:i:s', $ts);
            }
        }
    }

    // --- Extract main content from blog-content div ---
    $contentDivs = $xpath->query("//*[contains(@class, 'blog-content')]");
    if ($contentDivs->length > 0) {
        $contentNode = $contentDivs->item(0);
        $contentHtml = '';
        foreach ($contentNode->childNodes as $child) {
            $contentHtml .= $doc->saveHTML($child);
        }
        // Clean up the content
        $contentHtml = trim($contentHtml);
        // Remove any FAQ section that might be inside blog-content
        // (FAQs are stored separately in blog_faqs table)
        $data['content'] = $contentHtml;
    }

    // --- Extract FAQs from faq-item divs ---
    $faqItems = $xpath->query("//*[contains(@class, 'faq-item')]");
    if ($faqItems->length > 0) {
        foreach ($faqItems as $faqItem) {
            $question = '';
            $answer = '';

            // Get h3 for question
            $h3s = $faqItem->getElementsByTagName('h3');
            if ($h3s->length > 0) {
                $question = trim($h3s->item(0)->textContent);
            }

            // Get the answer - everything after h3 (usually in a div or p)
            $answerParts = [];
            $ps = $faqItem->getElementsByTagName('p');
            foreach ($ps as $p) {
                $answerParts[] = trim($p->textContent);
            }
            $answer = implode(' ', $answerParts);

            if ($question && $answer) {
                $data['faqs'][] = ['question' => $question, 'answer' => $answer];
            }
        }
    }

    // Also try extracting FAQs from JSON-LD FAQPage schema as fallback
    if (empty($data['faqs'])) {
        $scripts = $doc->getElementsByTagName('script');
        foreach ($scripts as $script) {
            if ($script->getAttribute('type') === 'application/ld+json') {
                $json = json_decode($script->textContent, true);
                if ($json && isset($json['@type']) && $json['@type'] === 'FAQPage' && isset($json['mainEntity'])) {
                    foreach ($json['mainEntity'] as $entity) {
                        if (isset($entity['name']) && isset($entity['acceptedAnswer']['text'])) {
                            $data['faqs'][] = [
                                'question' => $entity['name'],
                                'answer' => $entity['acceptedAnswer']['text']
                            ];
                        }
                    }
                }
            }
        }
    }

    // --- Fallback: If no publish_date found, use file modification time ---
    if (!$data['publish_date']) {
        $data['publish_date'] = date('Y-m-d H:i:s');
    }

    return $data;
}
