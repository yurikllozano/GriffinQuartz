<?php
/**
 * Lead Submission API Endpoint
 * Handles all form submissions and saves to database
 */

header('Content-Type: application/json');

// Include configuration
require_once 'config.php';

// CORS handling
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
if (in_array($origin, ALLOWED_ORIGINS)) {
    header("Access-Control-Allow-Origin: $origin");
}
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit();
}

// Get JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit();
}

// Sanitize and validate input
function sanitize($value) {
    return htmlspecialchars(trim($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePhone($phone) {
    // Remove non-numeric characters for validation
    $cleaned = preg_replace('/[^0-9]/', '', $phone);
    return strlen($cleaned) >= 10;
}

// Extract and sanitize fields
$formType = sanitize($data['form_type'] ?? 'contact');
$name = sanitize($data['name'] ?? '');
$email = sanitize($data['email'] ?? '');
$phone = sanitize($data['phone'] ?? '');
$project = sanitize($data['project'] ?? '');
$message = sanitize($data['message'] ?? '');
$pageUrl = sanitize($data['page_url'] ?? '');
$pageTitle = sanitize($data['page_title'] ?? '');

// Additional fields for quote calculator
$projectType = sanitize($data['project_type'] ?? '');
$squareFootage = sanitize($data['square_footage'] ?? '');
$materialGrade = sanitize($data['material_grade'] ?? '');
$edgeProfile = sanitize($data['edge_profile'] ?? '');
$estimatedCost = sanitize($data['estimated_cost'] ?? '');

// Validation
$errors = [];

if (empty($email)) {
    $errors[] = 'Email is required';
} elseif (!validateEmail($email)) {
    $errors[] = 'Invalid email format';
}

// Name required for non-newsletter forms
if ($formType !== 'newsletter' && empty($name)) {
    $errors[] = 'Name is required';
}

// Phone validation (if provided)
if (!empty($phone) && !validatePhone($phone)) {
    $errors[] = 'Invalid phone number';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit();
}

// Connect to database
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
    error_log("Database connection failed: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Insert lead into database
try {
    $sql = "INSERT INTO leads (
        form_type, name, email, phone, project, message,
        page_url, page_title, project_type, square_footage,
        material_grade, edge_profile, estimated_cost,
        ip_address, user_agent, created_at
    ) VALUES (
        :form_type, :name, :email, :phone, :project, :message,
        :page_url, :page_title, :project_type, :square_footage,
        :material_grade, :edge_profile, :estimated_cost,
        :ip_address, :user_agent, NOW()
    )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':form_type' => $formType,
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':project' => $project,
        ':message' => $message,
        ':page_url' => $pageUrl,
        ':page_title' => $pageTitle,
        ':project_type' => $projectType,
        ':square_footage' => $squareFootage,
        ':material_grade' => $materialGrade,
        ':edge_profile' => $edgeProfile,
        ':estimated_cost' => $estimatedCost,
        ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
        ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
    ]);

    $leadId = $pdo->lastInsertId();

    // Send email notification (optional)
    sendEmailNotification($formType, $name, $email, $phone, $project, $message, $leadId);

    echo json_encode([
        'success' => true,
        'message' => 'Thank you! We\'ll be in touch soon.',
        'lead_id' => $leadId
    ]);

} catch (PDOException $e) {
    error_log("Lead insertion failed: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save your information']);
    exit();
}

/**
 * Send email notification to admin
 */
function sendEmailNotification($formType, $name, $email, $phone, $project, $message, $leadId) {
    $to = ADMIN_EMAIL;
    $subject = "[" . SITE_NAME . "] New " . ucfirst($formType) . " Lead #$leadId";
    $fromEmail = defined('FROM_EMAIL') ? FROM_EMAIL : 'noreply@griffinquartz.com';
    $fromName = defined('FROM_NAME') ? FROM_NAME : SITE_NAME;

    // Build HTML email for better deliverability
    $body = "<!DOCTYPE html><html><head><meta charset='UTF-8'></head><body>";
    $body .= "<h2>New Lead Submission</h2>";
    $body .= "<table style='border-collapse: collapse; width: 100%; max-width: 600px;'>";
    $body .= "<tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Form Type</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>" . ucfirst($formType) . "</td></tr>";
    $body .= "<tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Lead ID</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>$leadId</td></tr>";
    $body .= "<tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Name</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>$name</td></tr>";
    $body .= "<tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Email</strong></td><td style='padding: 8px; border: 1px solid #ddd;'><a href='mailto:$email'>$email</a></td></tr>";
    $body .= "<tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Phone</strong></td><td style='padding: 8px; border: 1px solid #ddd;'><a href='tel:$phone'>$phone</a></td></tr>";
    if ($project) {
        $body .= "<tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Project</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>$project</td></tr>";
    }
    if ($message) {
        $body .= "<tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Message</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>" . nl2br($message) . "</td></tr>";
    }
    $body .= "<tr><td style='padding: 8px; border: 1px solid #ddd;'><strong>Submitted</strong></td><td style='padding: 8px; border: 1px solid #ddd;'>" . date('Y-m-d H:i:s') . "</td></tr>";
    $body .= "</table>";
    $body .= "</body></html>";

    // Headers for better deliverability
    $headers = "From: $fromName <$fromEmail>\r\n";
    $headers .= "Reply-To: $name <$email>\r\n";
    $headers .= "Return-Path: $fromEmail\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "X-Priority: 1\r\n";

    @mail($to, $subject, $body, $headers, "-f$fromEmail");
}
