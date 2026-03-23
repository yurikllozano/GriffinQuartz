<?php
/**
 * Griffin Quartz - Lead Management Admin
 * View, add, and manage leads with sidebar navigation
 */

require_once __DIR__ . '/includes/admin-auth.php';
require_admin_login();

// Database connection for leads
require_once dirname(__DIR__) . '/api/config.php';

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle inline lead updates (source, etc.)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_lead' && isset($_POST['lead_id'])) {
        $updateFields = [];
        $updateParams = [];

        if (isset($_POST['source'])) {
            $updateFields[] = "source = ?";
            $updateParams[] = $_POST['source'];
        }

        if (!empty($updateFields)) {
            $updateParams[] = (int) $_POST['lead_id'];
            $stmt = $pdo->prepare("UPDATE leads SET " . implode(', ', $updateFields) . " WHERE id = ?");
            $stmt->execute($updateParams);
        }
        // Redirect to avoid resubmit
        header('Location: leads.php' . ($_GET ? '?' . http_build_query($_GET) : ''));
        exit();
    }

    if ($_POST['action'] === 'add_lead') {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $source = trim($_POST['source'] ?? '');
        $notes = trim($_POST['notes'] ?? '');
        $smsConsent = isset($_POST['sms_consent']) ? 1 : 0;

        if ($email !== '') {
            $stmt = $pdo->prepare("INSERT INTO leads (first_name, last_name, email, phone, source, sms_consent, notes, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'new', NOW(), NOW())");
            $stmt->execute([$firstName, $lastName, $email, $phone, $source, $smsConsent, $notes]);
        }
        header('Location: leads.php');
        exit();
    }
}

// Get filter parameters
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$sourceFilter = isset($_GET['source']) ? $_GET['source'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build query
$sql = "SELECT * FROM leads WHERE 1=1";
$params = [];

if ($statusFilter) {
    $sql .= " AND status = :status";
    $params[':status'] = $statusFilter;
}

if ($sourceFilter) {
    $sql .= " AND source = :source";
    $params[':source'] = $sourceFilter;
}

if ($search) {
    $sql .= " AND (first_name LIKE :search OR last_name LIKE :search2 OR email LIKE :search3 OR phone LIKE :search4 OR notes LIKE :search5)";
    $params[':search'] = "%$search%";
    $params[':search2'] = "%$search%";
    $params[':search3'] = "%$search%";
    $params[':search4'] = "%$search%";
    $params[':search5'] = "%$search%";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get statuses for filter
$statuses = $pdo->query("SELECT DISTINCT status FROM leads ORDER BY status")->fetchAll(PDO::FETCH_COLUMN);

// Get lead sources for dropdowns
$leadSources = $pdo->query("SELECT * FROM lead_sources WHERE is_active = 1 ORDER BY sort_order ASC, name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Get distinct sources currently used in leads (for filter dropdown)
$usedSources = $pdo->query("SELECT DISTINCT source FROM leads WHERE source IS NOT NULL AND source != '' ORDER BY source")->fetchAll(PDO::FETCH_COLUMN);

// Count stats
$totalLeads = $pdo->query("SELECT COUNT(*) FROM leads")->fetchColumn();
$todayLeads = $pdo->query("SELECT COUNT(*) FROM leads WHERE DATE(created_at) = CURDATE()")->fetchColumn();
$weekLeads = $pdo->query("SELECT COUNT(*) FROM leads WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn();

$page_title = 'Leads Manager';

// Additional styles for leads page
$extra_head = '
<style>
    .badge-new { background: #e3f2fd; color: #1976d2; }
    .badge-contacted { background: #fff3e0; color: #f57c00; }
    .badge-qualified { background: #e8f5e9; color: #388e3c; }
    .badge-converted { background: #f3e5f5; color: #7b1fa2; }
    .badge-unsubscribed { background: #fce4ec; color: #c2185b; }
    .message-preview { max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer; }

    /* Modal overlay (shared) */
    .modal-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center; }
    .modal-overlay.active { display: flex; }
    .modal-box { background: #fff; border-radius: 12px; padding: 2rem; max-width: 600px; width: 90%; max-height: 85vh; overflow-y: auto; position: relative; }
    .modal-box h2 { margin: 0 0 1.5rem; font-size: 1.25rem; color: #1a1a2e; }
    .modal-box .close-btn { position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #666; }
    .modal-box .close-btn:hover { color: #333; }

    /* Lead detail fields */
    .lead-detail { margin-bottom: 1rem; }
    .lead-detail label { display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #888; margin-bottom: 0.25rem; }
    .lead-detail .value { font-size: 0.9375rem; color: #1a1a2e; line-height: 1.6; }
    .lead-detail .value.message-full { background: #f8f9fa; padding: 1rem; border-radius: 8px; white-space: pre-wrap; word-wrap: break-word; }

    /* Header buttons */
    .header-actions { display: flex; gap: 0.5rem; }

    /* Form rows */
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-row .form-group { margin-bottom: 1rem; }
    .form-group.full-width { grid-column: 1 / -1; }

    /* Source management table */
    .sources-table { width: 100%; border-collapse: collapse; }
    .sources-table th, .sources-table td { padding: 0.5rem; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
    .sources-table th { font-size: 0.7rem; text-transform: uppercase; color: #888; }
    .sources-table input[type="text"],
    .sources-table input[type="number"] { padding: 0.375rem 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.875rem; width: 100%; }
    .sources-table input[type="number"] { width: 60px; }

    /* Toggle switch */
    .toggle { position: relative; display: inline-block; width: 40px; height: 22px; }
    .toggle input { opacity: 0; width: 0; height: 0; }
    .toggle .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: #ccc; border-radius: 22px; transition: 0.2s; }
    .toggle .slider:before { position: absolute; content: ""; height: 16px; width: 16px; left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: 0.2s; }
    .toggle input:checked + .slider { background: #4caf50; }
    .toggle input:checked + .slider:before { transform: translateX(18px); }

    /* Inline alert in modal */
    .modal-alert { padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.875rem; display: none; }
    .modal-alert.success { background: #d4edda; color: #155724; display: block; }
    .modal-alert.error { background: #f8d7da; color: #721c24; display: block; }

    /* Source badge in table */
    .source-badge { display: inline-block; padding: 0.125rem 0.5rem; border-radius: 4px; font-size: 0.7rem; background: #f0f0f0; color: #555; }

    /* Manage sources modal wider */
    #sourcesModal .modal-box { max-width: 700px; }

    /* Add source row */
    .add-source-row { display: flex; gap: 0.5rem; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #eee; }
    .add-source-row input { flex: 1; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.875rem; }
</style>';

include __DIR__ . '/includes/admin-header.php';
?>

<div class="page-title-row">
    <h1>Leads Manager</h1>
    <div class="header-actions">
        <button class="btn btn-secondary" onclick="openSourcesModal()">Manage Sources</button>
        <button class="btn btn-primary" onclick="openAddLeadModal()">+ Add Lead</button>
    </div>
</div>

<div class="stats">
    <div class="stat-card">
        <h3>Total Leads</h3>
        <div class="number"><?= $totalLeads ?></div>
    </div>
    <div class="stat-card">
        <h3>Today</h3>
        <div class="number"><?= $todayLeads ?></div>
    </div>
    <div class="stat-card">
        <h3>This Week</h3>
        <div class="number"><?= $weekLeads ?></div>
    </div>
</div>

<form class="filters" method="GET">
    <select name="status">
        <option value="">All Statuses</option>
        <?php foreach ($statuses as $s): ?>
            <option value="<?= htmlspecialchars($s) ?>" <?= $statusFilter === $s ? 'selected' : '' ?>>
                <?= ucfirst($s) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <select name="source">
        <option value="">All Sources</option>
        <?php foreach ($usedSources as $src): ?>
            <option value="<?= htmlspecialchars($src) ?>" <?= $sourceFilter === $src ? 'selected' : '' ?>>
                <?= htmlspecialchars($src) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="text" name="search" placeholder="Search name, email, phone..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit" class="btn btn-primary">Filter</button>
    <?php if ($statusFilter || $search || $sourceFilter): ?>
        <a href="leads.php" class="btn btn-secondary">Clear</a>
    <?php endif; ?>
</form>

<p style="color: #666; font-size: 0.875rem; margin-bottom: 1rem;">Showing <?= count($leads) ?> lead(s)</p>

<div class="card">
    <div class="table-wrapper">
        <?php if (empty($leads)): ?>
            <div class="empty">No leads found</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Source</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leads as $lead): ?>
                        <tr style="cursor: pointer;" onclick="openLead(<?= htmlspecialchars(json_encode($lead), ENT_QUOTES) ?>)">
                            <td><?= date('M j, g:ia', strtotime($lead['created_at'])) ?></td>
                            <td><span class="badge badge-<?= htmlspecialchars($lead['status']) ?>"><?= ucfirst($lead['status']) ?></span></td>
                            <td><?php if (!empty($lead['source'])): ?><span class="source-badge"><?= htmlspecialchars($lead['source']) ?></span><?php else: ?>-<?php endif; ?></td>
                            <td><?= htmlspecialchars(trim(($lead['first_name'] ?? '') . ' ' . ($lead['last_name'] ?? '')) ?: '-') ?></td>
                            <td><a href="mailto:<?= htmlspecialchars($lead['email']) ?>" onclick="event.stopPropagation()"><?= htmlspecialchars($lead['email']) ?></a></td>
                            <td><a href="tel:<?= htmlspecialchars($lead['phone']) ?>" onclick="event.stopPropagation()"><?= htmlspecialchars($lead['phone'] ?: '-') ?></a></td>
                            <td class="message-preview"><?= htmlspecialchars($lead['notes'] ?: '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- ==================== ADD LEAD MODAL ==================== -->
<div class="modal-overlay" id="addLeadModal">
    <div class="modal-box">
        <button class="close-btn" onclick="closeAllModals()">&times;</button>
        <h2>Add Lead</h2>
        <form method="POST" action="leads.php">
            <input type="hidden" name="action" value="add_lead">
            <div class="form-row">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" placeholder="John">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" placeholder="Smith">
                </div>
            </div>
            <div class="form-group">
                <label>Email <span style="color: #dc3545;">*</span></label>
                <input type="email" name="email" required placeholder="john@example.com">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" placeholder="(555) 123-4567">
            </div>
            <div class="form-group">
                <label>Source</label>
                <select name="source">
                    <option value="">-- Select Source --</option>
                    <?php foreach ($leadSources as $src): ?>
                        <option value="<?= htmlspecialchars($src['name']) ?>"><?= htmlspecialchars($src['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: normal; cursor: pointer;">
                    <input type="checkbox" name="sms_consent" value="1"> SMS consent given
                </label>
            </div>
            <div class="form-group">
                <label>Notes</label>
                <textarea name="notes" rows="3" placeholder="Any additional notes..."></textarea>
            </div>
            <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeAllModals()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Lead</button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== LEAD DETAIL / EDIT MODAL ==================== -->
<div class="modal-overlay" id="leadModal">
    <div class="modal-box">
        <button class="close-btn" onclick="closeAllModals()">&times;</button>
        <h2 id="modalTitle">Lead Details</h2>

        <form method="POST" action="leads.php" id="editLeadForm">
            <input type="hidden" name="action" value="update_lead">
            <input type="hidden" name="lead_id" id="editLeadId">

            <div class="lead-detail">
                <label>Date</label>
                <div class="value" id="modalDate"></div>
            </div>
            <div class="lead-detail">
                <label>Status</label>
                <div class="value" id="modalStatus"></div>
            </div>
            <div class="lead-detail">
                <label>Name</label>
                <div class="value" id="modalName"></div>
            </div>
            <div class="lead-detail">
                <label>Email</label>
                <div class="value" id="modalEmail"></div>
            </div>
            <div class="lead-detail" id="modalPhoneRow">
                <label>Phone</label>
                <div class="value" id="modalPhone"></div>
            </div>
            <div class="lead-detail">
                <label>SMS Consent</label>
                <div class="value" id="modalSmsConsent"></div>
            </div>
            <div class="lead-detail">
                <label>Source</label>
                <select name="source" id="modalSource" style="padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.875rem; width: 100%;">
                    <option value="">-- No Source --</option>
                    <?php foreach ($leadSources as $src): ?>
                        <option value="<?= htmlspecialchars($src['name']) ?>"><?= htmlspecialchars($src['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="lead-detail" id="modalNotesRow">
                <label>Notes</label>
                <div class="value message-full" id="modalNotes"></div>
            </div>

            <div style="display: flex; gap: 0.5rem; justify-content: flex-end; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #eee;">
                <button type="button" class="btn btn-secondary" onclick="closeAllModals()">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== MANAGE SOURCES MODAL ==================== -->
<div class="modal-overlay" id="sourcesModal">
    <div class="modal-box">
        <button class="close-btn" onclick="closeAllModals()">&times;</button>
        <h2>Manage Lead Sources</h2>
        <div id="sourcesAlert" class="modal-alert"></div>

        <table class="sources-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th style="width: 70px;">Order</th>
                    <th style="width: 60px;">Active</th>
                    <th style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody id="sourcesTableBody">
                <!-- Populated by JS -->
            </tbody>
        </table>

        <div class="add-source-row">
            <input type="text" id="newSourceName" placeholder="New source name...">
            <input type="number" id="newSourceOrder" placeholder="#" style="width: 60px;" value="0">
            <button class="btn btn-primary btn-sm" onclick="addSource()">Add</button>
        </div>
    </div>
</div>

<script>
// ===== Lead Sources data from PHP =====
var leadSourceNames = <?= json_encode(array_column($leadSources, 'name')) ?>;

// ===== Close all modals =====
function closeAllModals() {
    document.querySelectorAll('.modal-overlay').forEach(function(m) {
        m.classList.remove('active');
    });
}

// Close on overlay click or Escape
document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) closeAllModals();
    });
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeAllModals();
});

// ===== ADD LEAD MODAL =====
function openAddLeadModal() {
    closeAllModals();
    document.getElementById('addLeadModal').classList.add('active');
}

// ===== LEAD DETAIL / EDIT MODAL =====
function openLead(lead) {
    closeAllModals();
    var fullName = ((lead.first_name || '') + ' ' + (lead.last_name || '')).trim() || 'Lead';
    document.getElementById('editLeadId').value = lead.id;
    document.getElementById('modalTitle').textContent = fullName;
    document.getElementById('modalDate').textContent = lead.created_at || '-';
    document.getElementById('modalStatus').innerHTML = '<span class="badge badge-' + escHtml(lead.status || 'new') + '">' + escHtml(ucfirst(lead.status || 'new')) + '</span>';
    document.getElementById('modalName').textContent = fullName;
    document.getElementById('modalEmail').innerHTML = lead.email ? '<a href="mailto:' + escHtml(lead.email) + '">' + escHtml(lead.email) + '</a>' : '-';
    document.getElementById('modalSmsConsent').textContent = lead.sms_consent == 1 ? 'Yes' : 'No';

    var phoneRow = document.getElementById('modalPhoneRow');
    if (lead.phone) {
        phoneRow.style.display = '';
        document.getElementById('modalPhone').innerHTML = '<a href="tel:' + escHtml(lead.phone) + '">' + escHtml(lead.phone) + '</a>';
    } else {
        phoneRow.style.display = 'none';
    }

    // Source dropdown
    var sourceSelect = document.getElementById('modalSource');
    var currentSource = lead.source || '';

    // Reset options: start with managed sources
    sourceSelect.innerHTML = '<option value="">-- No Source --</option>';
    leadSourceNames.forEach(function(name) {
        var opt = document.createElement('option');
        opt.value = name;
        opt.textContent = name;
        if (name === currentSource) opt.selected = true;
        sourceSelect.appendChild(opt);
    });

    // If current source is a legacy value not in managed list, add it
    if (currentSource && leadSourceNames.indexOf(currentSource) === -1) {
        var legacyOpt = document.createElement('option');
        legacyOpt.value = currentSource;
        legacyOpt.textContent = currentSource + ' (legacy)';
        legacyOpt.selected = true;
        sourceSelect.appendChild(legacyOpt);
    }

    var notesRow = document.getElementById('modalNotesRow');
    if (lead.notes) {
        notesRow.style.display = '';
        document.getElementById('modalNotes').textContent = lead.notes;
    } else {
        notesRow.style.display = 'none';
    }

    document.getElementById('leadModal').classList.add('active');
}

function escHtml(str) {
    var div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

// ===== MANAGE SOURCES MODAL =====
function openSourcesModal() {
    closeAllModals();
    loadSources();
    document.getElementById('sourcesModal').classList.add('active');
}

function showSourcesAlert(msg, type) {
    var el = document.getElementById('sourcesAlert');
    el.textContent = msg;
    el.className = 'modal-alert ' + type;
    setTimeout(function() { el.className = 'modal-alert'; }, 4000);
}

function loadSources() {
    fetch('/api/lead-sources.php?all=1')
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (!res.success) return;
            var tbody = document.getElementById('sourcesTableBody');
            tbody.innerHTML = '';
            res.data.forEach(function(src) {
                var tr = document.createElement('tr');
                tr.setAttribute('data-id', src.id);
                tr.innerHTML =
                    '<td><input type="text" value="' + escAttr(src.name) + '" data-field="name"></td>' +
                    '<td><input type="number" value="' + src.sort_order + '" data-field="sort_order" style="width:60px;"></td>' +
                    '<td><label class="toggle"><input type="checkbox" ' + (src.is_active == 1 ? 'checked' : '') + ' data-field="is_active"><span class="slider"></span></label></td>' +
                    '<td><button class="btn btn-sm btn-primary" onclick="saveSource(' + src.id + ', this)">Save</button> <button class="btn btn-sm btn-danger" onclick="deleteSource(' + src.id + ', this)">Del</button></td>';
                tbody.appendChild(tr);
            });
        });
}

function escAttr(str) {
    return String(str).replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

function saveSource(id, btn) {
    var tr = btn.closest('tr');
    var name = tr.querySelector('[data-field="name"]').value.trim();
    var sortOrder = parseInt(tr.querySelector('[data-field="sort_order"]').value) || 0;
    var isActive = tr.querySelector('[data-field="is_active"]').checked ? 1 : 0;

    fetch('/api/lead-sources.php?id=' + id, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name: name, sort_order: sortOrder, is_active: isActive })
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
        if (res.success) {
            showSourcesAlert('Source updated', 'success');
            refreshSourceDropdowns();
        } else {
            showSourcesAlert(res.message || 'Error updating source', 'error');
        }
    });
}

function deleteSource(id, btn) {
    if (!confirm('Delete this source? This cannot be undone.')) return;

    fetch('/api/lead-sources.php?id=' + id, { method: 'DELETE' })
    .then(function(r) { return r.json(); })
    .then(function(res) {
        if (res.success) {
            btn.closest('tr').remove();
            showSourcesAlert('Source deleted', 'success');
            refreshSourceDropdowns();
        } else {
            showSourcesAlert(res.message || 'Cannot delete source', 'error');
        }
    });
}

function addSource() {
    var nameInput = document.getElementById('newSourceName');
    var orderInput = document.getElementById('newSourceOrder');
    var name = nameInput.value.trim();
    var sortOrder = parseInt(orderInput.value) || 0;

    if (!name) {
        showSourcesAlert('Enter a source name', 'error');
        return;
    }

    fetch('/api/lead-sources.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name: name, sort_order: sortOrder })
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
        if (res.success) {
            nameInput.value = '';
            orderInput.value = '0';
            showSourcesAlert('Source added', 'success');
            loadSources();
            refreshSourceDropdowns();
        } else {
            showSourcesAlert(res.message || 'Error adding source', 'error');
        }
    });
}

// Refresh source dropdowns (Add Lead + Edit Lead) after managing sources
function refreshSourceDropdowns() {
    fetch('/api/lead-sources.php')
    .then(function(r) { return r.json(); })
    .then(function(res) {
        if (!res.success) return;
        leadSourceNames = res.data.map(function(s) { return s.name; });

        // Update Add Lead dropdown
        var addSelect = document.querySelector('#addLeadModal select[name="source"]');
        if (addSelect) {
            addSelect.innerHTML = '<option value="">-- Select Source --</option>';
            res.data.forEach(function(s) {
                var opt = document.createElement('option');
                opt.value = s.name;
                opt.textContent = s.name;
                addSelect.appendChild(opt);
            });
        }
    });
}
</script>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
