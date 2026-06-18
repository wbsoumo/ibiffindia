<?php
/**
 * Global Configuration for Ibiff India
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'ibiffind_raju');
define('DB_USER', 'ibiffind_raju');
define('DB_PASS', 'GLCbRskADBy6WtHdYRD4');

// Site Settings
define('SITE_NAME', 'IBIFF INDIA');
define('SITE_URL', 'http://taskbazi.online');
define('CONTACT_EMAIL', 'info@ibiffindia.com');

// Path Constants
define('BASE_PATH', dirname(__DIR__));
define('UPLOAD_PATH', BASE_PATH . '/assets/uploads');

// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
