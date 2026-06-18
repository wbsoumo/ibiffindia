<?php
require_once '../includes/header.php';

if (!isAdminLoggedIn()) {
    redirect('../login.php');
}

if (isset($_GET['id']) && $db) {
    $id = intval($_GET['id']);
    
    // Check if gallery exists
    $stmt = $db->prepare("SELECT image FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $photo = $stmt->fetch();
    
    if ($photo) {
        $stmt = $db->prepare("DELETE FROM gallery WHERE id = ?");
        if ($stmt->execute([$id])) {
            setFlash('success', 'Photo deleted successfully.');
        }
    }
}

redirect('index.php');
