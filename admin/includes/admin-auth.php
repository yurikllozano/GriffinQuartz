<?php
/**
 * Griffin Quartz - Admin Authentication
 * Shared authentication for all admin pages
 */

session_start();

// Admin password - should match leads.php
define('ADMIN_PASSWORD', 'Silver@24');

// Handle login
if (isset($_POST['admin_password'])) {
    if ($_POST['admin_password'] === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        // Redirect to remove POST data
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    } else {
        $auth_error = 'Incorrect password';
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /admin/leads.php');
    exit();
}

// CSRF token generation
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function verify_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['csrf_token']) . '">';
}

// Check if logged in
function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Show login form if not authenticated
function require_admin_login() {
    global $auth_error;

    if (!is_admin_logged_in()) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin Login | Griffin Quartz</title>
            <style>
                * { box-sizing: border-box; margin: 0; padding: 0; }
                body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f5f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
                .login-box { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
                h1 { font-size: 1.5rem; margin-bottom: 1.5rem; color: #333; }
                input[type="password"] { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; margin-bottom: 1rem; }
                button { width: 100%; padding: 0.75rem; background: #FDB913; border: none; border-radius: 4px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background 0.2s; }
                button:hover { background: #E0A510; }
                .error { color: #dc3545; margin-bottom: 1rem; font-size: 0.875rem; }
            </style>
        </head>
        <body>
            <div class="login-box">
                <h1>Griffin Quartz Admin</h1>
                <?php if (isset($auth_error)) echo "<p class='error'>$auth_error</p>"; ?>
                <form method="POST">
                    <input type="password" name="admin_password" placeholder="Enter password" required autofocus>
                    <button type="submit">Login</button>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit();
    }
}

// Database connection helper
function get_db_connection() {
    static $pdo = null;

    if ($pdo === null) {
        require_once dirname(__DIR__, 2) . '/api/config.php';

        try {
            $pdo = new PDO(
                "mysql:host=" . DB_BLOG_HOST . ";dbname=" . DB_BLOG_NAME . ";charset=utf8mb4",
                DB_BLOG_USER,
                DB_BLOG_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    return $pdo;
}

// Sanitize output helper
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// Generate URL-friendly slug
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return $text ?: 'untitled';
}

// Format date for display
function format_date($date, $format = 'M j, Y g:ia') {
    return $date ? date($format, strtotime($date)) : '-';
}
