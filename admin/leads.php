<?php
/**
 * Griffin Quartz - Lead Management Admin
 * View and manage leads with sidebar navigation
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

// Get filter parameters
$formType = isset($_GET['type']) ? $_GET['type'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build query
$sql = "SELECT * FROM leads WHERE 1=1";
$params = [];

if ($formType) {
    $sql .= " AND form_type = :form_type";
    $params[':form_type'] = $formType;
}

if ($search) {
    $sql .= " AND (name LIKE :search OR email LIKE :search2 OR phone LIKE :search3 OR message LIKE :search4)";
    $params[':search'] = "%$search%";
    $params[':search2'] = "%$search%";
    $params[':search3'] = "%$search%";
    $params[':search4'] = "%$search%";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get form types for filter
$types = $pdo->query("SELECT DISTINCT form_type FROM leads ORDER BY form_type")->fetchAll(PDO::FETCH_COLUMN);

// Count stats
$totalLeads = $pdo->query("SELECT COUNT(*) FROM leads")->fetchColumn();
$todayLeads = $pdo->query("SELECT COUNT(*) FROM leads WHERE DATE(created_at) = CURDATE()")->fetchColumn();
$weekLeads = $pdo->query("SELECT COUNT(*) FROM leads WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn();

$page_title = 'Leads Manager';

// Additional styles for leads page
$extra_head = '
<style>
    .badge-quote { background: #e3f2fd; color: #1976d2; }
    .badge-contact { background: #e8f5e9; color: #388e3c; }
    .badge-newsletter { background: #fff3e0; color: #f57c00; }
    .badge-service_quote { background: #f3e5f5; color: #7b1fa2; }
    .badge-product_quote { background: #fce4ec; color: #c2185b; }
    .badge-samples_request { background: #e0f7fa; color: #0097a7; }
    .message-preview { max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; cursor: pointer; }
    .message-preview.expanded { white-space: normal; overflow: visible; text-overflow: unset; max-width: 400px; }

    /* Lead detail modal */
    .lead-modal-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center; }
    .lead-modal-overlay.active { display: flex; }
    .lead-modal { background: #fff; border-radius: 12px; padding: 2rem; max-width: 600px; width: 90%; max-height: 80vh; overflow-y: auto; position: relative; }
    .lead-modal h2 { margin: 0 0 1.5rem; font-size: 1.25rem; color: #1a1a2e; }
    .lead-modal .close-btn { position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #666; }
    .lead-modal .close-btn:hover { color: #333; }
    .lead-detail { margin-bottom: 1rem; }
    .lead-detail label { display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #888; margin-bottom: 0.25rem; }
    .lead-detail .value { font-size: 0.9375rem; color: #1a1a2e; line-height: 1.6; }
    .lead-detail .value.message-full { background: #f8f9fa; padding: 1rem; border-radius: 8px; white-space: pre-wrap; word-wrap: break-word; }
</style>';

include __DIR__ . '/includes/admin-header.php';
?>

<div class="page-title-row">
    <h1>Leads Manager</h1>
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
    <select name="type">
        <option value="">All Types</option>
        <?php foreach ($types as $type): ?>
            <option value="<?= htmlspecialchars($type) ?>" <?= $formType === $type ? 'selected' : '' ?>>
                <?= ucfirst(str_replace('_', ' ', $type)) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="text" name="search" placeholder="Search name, email, phone..." value="<?= htmlspecialchars($search) ?>">
    <button type="submit" class="btn btn-primary">Filter</button>
    <?php if ($formType || $search): ?>
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
                        <th>Type</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Page</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leads as $lead): ?>
                        <tr style="cursor: pointer;" onclick="openLead(<?= htmlspecialchars(json_encode($lead), ENT_QUOTES) ?>)">
                            <td><?= date('M j, g:ia', strtotime($lead['created_at'])) ?></td>
                            <td><span class="badge badge-<?= $lead['form_type'] ?>"><?= ucfirst(str_replace('_', ' ', $lead['form_type'])) ?></span></td>
                            <td><?= htmlspecialchars($lead['name'] ?: '-') ?></td>
                            <td><a href="mailto:<?= htmlspecialchars($lead['email']) ?>" onclick="event.stopPropagation()"><?= htmlspecialchars($lead['email']) ?></a></td>
                            <td><a href="tel:<?= htmlspecialchars($lead['phone']) ?>" onclick="event.stopPropagation()"><?= htmlspecialchars($lead['phone'] ?: '-') ?></a></td>
                            <td class="message-preview"><?= htmlspecialchars($lead['message'] ?: '-') ?></td>
                            <td style="font-size: 0.75rem; color: #666;"><?= htmlspecialchars($lead['page_title'] ?: '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- Lead Detail Modal -->
<div class="lead-modal-overlay" id="leadModal">
    <div class="lead-modal">
        <button class="close-btn" onclick="closeModal()">&times;</button>
        <h2 id="modalTitle">Lead Details</h2>
        <div class="lead-detail">
            <label>Date</label>
            <div class="value" id="modalDate"></div>
        </div>
        <div class="lead-detail">
            <label>Type</label>
            <div class="value" id="modalType"></div>
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
        <div class="lead-detail" id="modalProjectRow">
            <label>Project</label>
            <div class="value" id="modalProject"></div>
        </div>
        <div class="lead-detail" id="modalMessageRow">
            <label>Message</label>
            <div class="value message-full" id="modalMessage"></div>
        </div>
        <div class="lead-detail" id="modalPageRow">
            <label>Submitted From</label>
            <div class="value" id="modalPage"></div>
        </div>
    </div>
</div>

<script>
function openLead(lead) {
    document.getElementById('modalTitle').textContent = (lead.name || 'Lead') + ' — ' + (lead.form_type || '').replace('_', ' ');
    document.getElementById('modalDate').textContent = lead.created_at || '-';
    document.getElementById('modalType').textContent = (lead.form_type || '-').replace('_', ' ');
    document.getElementById('modalName').textContent = lead.name || '-';
    document.getElementById('modalEmail').innerHTML = lead.email ? '<a href="mailto:' + lead.email + '">' + lead.email + '</a>' : '-';

    var phoneRow = document.getElementById('modalPhoneRow');
    if (lead.phone) {
        phoneRow.style.display = '';
        document.getElementById('modalPhone').innerHTML = '<a href="tel:' + lead.phone + '">' + lead.phone + '</a>';
    } else {
        phoneRow.style.display = 'none';
    }

    var projectRow = document.getElementById('modalProjectRow');
    if (lead.project) {
        projectRow.style.display = '';
        document.getElementById('modalProject').textContent = lead.project;
    } else {
        projectRow.style.display = 'none';
    }

    var messageRow = document.getElementById('modalMessageRow');
    if (lead.message) {
        messageRow.style.display = '';
        document.getElementById('modalMessage').textContent = lead.message;
    } else {
        messageRow.style.display = 'none';
    }

    var pageRow = document.getElementById('modalPageRow');
    if (lead.page_title || lead.page_url) {
        pageRow.style.display = '';
        document.getElementById('modalPage').textContent = (lead.page_title || '') + (lead.page_url ? ' (' + lead.page_url + ')' : '');
    } else {
        pageRow.style.display = 'none';
    }

    document.getElementById('leadModal').classList.add('active');
}

function closeModal() {
    document.getElementById('leadModal').classList.remove('active');
}

document.getElementById('leadModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
</script>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
