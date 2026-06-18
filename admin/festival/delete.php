<?php
require_once '../includes/header.php';

if (!isAdminLoggedIn()) {
    redirect('../login.php');
}

if (isset($_GET['id']) && $db) {
    $id = intval($_GET['id']);
    
    // Check if event exists
    $stmt = $db->prepare("SELECT id FROM festival_schedule WHERE id = ?");
    $stmt->execute([$id]);
    $event = $stmt->fetch();
    
    if ($event) {
        $stmt = $db->prepare("DELETE FROM festival_schedule WHERE id = ?");
        if ($stmt->execute([$id])) {
            setFlash('success', 'Event deleted successfully.');
        }
    }
}

redirect('index.php');
