<?php
require_once __DIR__ . '/includes/init.php';

if (!isAdminLoggedIn()) {
    http_response_code(403);
    exit('Forbidden');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['media'])) {
    $mediaItems = $_POST['media']; // array of IDs in the new order
    
    $position = 1;
    $stmt = $db->prepare("UPDATE homepage_media SET display_order = ? WHERE id = ?");
    
    foreach ($mediaItems as $id) {
        $stmt->execute([$position, (int)$id]);
        $position++;
    }
    
    echo "Success";
} else {
    http_response_code(400);
    exit('Invalid request');
}
?>
