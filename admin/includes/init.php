<?php
// Core initialization script for the Admin Panel
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/functions.php';

// Authentication Check
$current_page = basename($_SERVER['PHP_SELF']);
$public_pages = ['login.php', 'register.php'];

if (!in_array($current_page, $public_pages)) {
    if (!isAdminLoggedIn()) {
        redirect('login.php');
    }
}
