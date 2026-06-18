<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo $basePath; ?>dashboard.php" class="brand-link text-center">
    <span class="brand-text font-weight-light font-weight-bold">IBIFF <span class="gold">INDIA</span></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-4">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <li class="nav-item">
          <a href="<?php echo $basePath; ?>dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active bg-gold' : ''; ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo $basePath; ?>films/index.php" class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], '/films/') !== false ? 'active bg-gold' : ''; ?>">
            <i class="nav-icon fas fa-film"></i>
            <p>Manage Films</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo $basePath; ?>gallery/index.php" class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], '/gallery/') !== false ? 'active bg-gold' : ''; ?>">
            <i class="nav-icon fas fa-images"></i>
            <p>Manage Gallery</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo $basePath; ?>festival/index.php" class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], '/festival/') !== false ? 'active bg-gold' : ''; ?>">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>Festival Schedule</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo $basePath; ?>messages.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'active bg-gold' : ''; ?>">
            <i class="nav-icon fas fa-envelope"></i>
            <p>Messages</p>
          </a>
        </li>

        <li class="nav-header mt-3">SYSTEM</li>
        
        <li class="nav-item">
          <a href="<?php echo $basePath; ?>settings.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active bg-gold' : ''; ?>">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Website CMS</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo $basePath; ?>homepage_media.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'homepage_media.php' ? 'active bg-gold' : ''; ?>">
            <i class="nav-icon fas fa-photo-video"></i>
            <p>Homepage Media</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
