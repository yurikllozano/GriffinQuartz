<?php
/**
 * Lead Sources CRUD API
 * GET    - list sources (active only by default, ?all=1 for all)
 * POST   - create source (requires name)
 * PUT    - update source (requires id in URL path or query)
 * DELETE - delete source (blocked if leads reference it)
 */

header('Content-Type: application/json');

require_once __DIR__ . '/config.php';

// Auth check — require admin session
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Database connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

// Parse ID from query string
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

switch ($method) {

    case 'GET':
        $showAll = isset($_GET['all']) && $_GET['all'] == '1';
        $sql = "SELECT * FROM lead_sources";
        if (!$showAll) {
            $sql .= " WHERE is_active = 1";
        }
        $sql .= " ORDER BY sort_order ASC, name ASC";
        $sources = $pdo->query($sql)->fetchAll();
        echo json_encode(['success' => true, 'data' => $sources]);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $name = trim($input['name'] ?? '');
        $sortOrder = (int) ($input['sort_order'] ?? 0);

        if ($name === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Name is required']);
            exit();
        }

        // Check for duplicate name
        $check = $pdo->prepare("SELECT id FROM lead_sources WHERE name = ?");
        $check->execute([$name]);
        if ($check->fetch()) {
            http_response_code(409);
            echo json_encode(['success' => false, 'message' => 'A source with that name already exists']);
            exit();
        }

        $stmt = $pdo->prepare("INSERT INTO lead_sources (name, sort_order) VALUES (?, ?)");
        $stmt->execute([$name, $sortOrder]);

        echo json_encode([
            'success' => true,
            'message' => 'Source created',
            'data' => [
                'id' => (int) $pdo->lastInsertId(),
                'name' => $name,
                'is_active' => 1,
                'sort_order' => $sortOrder
            ]
        ]);
        break;

    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Source ID is required']);
            exit();
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $fields = [];
        $params = [];

        if (isset($input['name'])) {
            $name = trim($input['name']);
            if ($name === '') {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Name cannot be empty']);
                exit();
            }
            // Check for duplicate name (exclude current)
            $check = $pdo->prepare("SELECT id FROM lead_sources WHERE name = ? AND id != ?");
            $check->execute([$name, $id]);
            if ($check->fetch()) {
                http_response_code(409);
                echo json_encode(['success' => false, 'message' => 'A source with that name already exists']);
                exit();
            }
            $fields[] = "name = ?";
            $params[] = $name;
        }

        if (isset($input['is_active'])) {
            $fields[] = "is_active = ?";
            $params[] = (int) $input['is_active'];
        }

        if (isset($input['sort_order'])) {
            $fields[] = "sort_order = ?";
            $params[] = (int) $input['sort_order'];
        }

        if (empty($fields)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'No fields to update']);
            exit();
        }

        $params[] = $id;
        $sql = "UPDATE lead_sources SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        if ($stmt->rowCount() === 0) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Source not found']);
            exit();
        }

        echo json_encode(['success' => true, 'message' => 'Source updated']);
        break;

    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Source ID is required']);
            exit();
        }

        // Get the source name first
        $src = $pdo->prepare("SELECT name FROM lead_sources WHERE id = ?");
        $src->execute([$id]);
        $source = $src->fetch();

        if (!$source) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Source not found']);
            exit();
        }

        // Check if any leads reference this source
        $usage = $pdo->prepare("SELECT COUNT(*) FROM leads WHERE source = ?");
        $usage->execute([$source['name']]);
        $count = (int) $usage->fetchColumn();

        if ($count > 0) {
            http_response_code(409);
            echo json_encode([
                'success' => false,
                'message' => "$count lead(s) use this source. Deactivate it instead of deleting."
            ]);
            exit();
        }

        $del = $pdo->prepare("DELETE FROM lead_sources WHERE id = ?");
        $del->execute([$id]);

        echo json_encode(['success' => true, 'message' => 'Source deleted']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        break;
}
