<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);

    try {
        $stmt = $db->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $subject, $message])) {
            setFlash('success', 'Your message has been sent successfully! We will get back to you soon.');
        } else {
            setFlash('error', 'Something went wrong. Please try again later.');
        }
    } catch (PDOException $e) {
        setFlash('error', 'Database error: ' . $e->getMessage());
    }
    
    redirect('contact.php');
} else {
    redirect('contact.php');
}
?>
