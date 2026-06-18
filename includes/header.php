<?php 
require_once __DIR__ . '/config.php'; 
require_once __DIR__ . '/db.php'; 
require_once __DIR__ . '/functions.php'; 

$siteLogo = getSetting('site_logo', 'assets/images/logo.png');
$siteFavicon = getSetting('site_favicon', 'assets/images/favicon.ico');
$metaTitle = getSetting('meta_title', 'IBIFF INDIA | Indo-Bangla International Film Festival');
$metaDesc = getSetting('meta_description', 'Ibiff India - Indo-Bangla International Film Festival. Celebrating cinematic excellence and cross-border storytelling.');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . " | " . SITE_NAME : $metaTitle; ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo htmlspecialchars($metaDesc); ?>">
    <meta name="keywords" content="Ibiff India, Film Festival, International Film Festival, Short Films, Documentaries, Cinema">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;700;900&family=Poppins:wght@300;400;600;800&family=Cinzel:wght@400;700;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/responsive.css">
    
    <!-- Favicon -->
    <link rel="icon" href="<?php echo htmlspecialchars($siteFavicon); ?>">
</head>
<body>
