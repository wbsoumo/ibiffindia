<?php
require_once '../includes/header.php';

if (!isAdminLoggedIn()) {
    redirect('../login.php');
}

if (isset($_GET['id']) && $db) {
    $id = intval($_GET['id']);
    
    // Check if film exists
    $stmt = $db->prepare("SELECT poster FROM films WHERE id = ?");
    $stmt->execute([$id]);
    $film = $stmt->fetch();
    
    if ($film) {
        $stmt = $db->prepare("DELETE FROM films WHERE id = ?");
        if ($stmt->execute([$id])) {
            setFlash('success', 'Film deleted successfully.');
        }
    }
}

redirect('index.php');
