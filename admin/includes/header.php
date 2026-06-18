<?php 
require_once __DIR__ . '/init.php'; 

// For links handling based on depth
$basePath = (strpos($_SERVER['PHP_SELF'], '/films/') !== false || strpos($_SERVER['PHP_SELF'], '/gallery/') !== false || strpos($_SERVER['PHP_SELF'], '/festival/') !== false) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | IBIFF INDIA</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    <style>
        .gold { color: #d4af37; }
        .btn-gold { background-color: #d4af37; color: #000; font-weight: bold; border: none; }
        .btn-gold:hover { background-color: #f1c40f; }
        .text-gold { color: #d4af37 !important; }
        .bg-gold { background-color: #d4af37 !important; }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo $basePath; ?>../index.php" target="_blank" class="nav-link text-primary fw-bold"><i class="fas fa-external-link-alt mr-1"></i> View Live Site</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link text-danger" href="<?php echo $basePath; ?>logout.php">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <?php require_once __DIR__ . '/sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
