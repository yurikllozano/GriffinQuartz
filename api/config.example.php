<?php
/**
 * Database Configuration
 * Copy this file to config.php and update with your cPanel database credentials
 */

// Leads Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');  // e.g., 'Griffin_Quartz_Leads'
define('DB_USER', 'your_database_user');  // e.g., 'Yurikllozano'
define('DB_PASS', 'your_database_password');

// Blog Database
define('DB_BLOG_HOST', 'localhost');
define('DB_BLOG_NAME', 'your_blog_database');  // e.g., 'Blogs'
define('DB_BLOG_USER', 'your_database_user');
define('DB_BLOG_PASS', 'your_database_password');

/**
 * Site Configuration
 */
define('SITE_NAME', 'Griffin Quartz');
define('ADMIN_EMAIL', 'your@email.com');

/**
 * Mailgun
 */
define('MAILGUN_API_KEY', 'your-mailgun-api-key');
define('MAILGUN_DOMAIN', 'mg.griffinquartz.com');
define('FROM_EMAIL', 'noreply@mg.griffinquartz.com');
define('FROM_NAME', 'Griffin Quartz');

/**
 * Security
 */
define('ALLOWED_ORIGINS', [
    'https://griffinquartz.com',
    'https://www.griffinquartz.com',
    'http://localhost'
]);
