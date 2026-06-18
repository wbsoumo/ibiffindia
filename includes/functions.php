<?php
/**
 * Global Helper Functions
 */

/**
 * Sanitize input data
 */
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

/**
 * Redirect to a specific URL
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Generate SEO-friendly slug
 */
function createSlug($string) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    return $slug;
}

/**
 * Format date for display
 */
function formatDate($date, $format = "d M, Y") {
    return date($format, strtotime($date));
}

/**
 * Check if admin is logged in
 */
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}

/**
 * Set Flash Message
 */
function setFlash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

/**
 * Get Flash Message
 */
function getFlash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    return null;
}

/**
 * Get dynamic site setting
 */
function getSetting($key, $default = '') {
    global $db, $site_settings_cache;
    
    // Cache settings to avoid multiple DB calls
    if (!isset($site_settings_cache) && $db) {
        try {
            $stmt = $db->query("SELECT setting_key, setting_value FROM site_settings");
            $site_settings_cache = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        } catch (PDOException $e) {
            $site_settings_cache = [];
        }
    }
    
    return isset($site_settings_cache[$key]) ? $site_settings_cache[$key] : $default;
}
?>
