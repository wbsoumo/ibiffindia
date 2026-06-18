<?php 
require_once 'includes/header.php';

if (!isAdminLoggedIn()) {
    redirect('login.php');
}

// Fetch real stats
$totalFilms = 0;
$totalGallery = 0;
$totalMessages = 0;
$upcomingEvents = 0;

if ($db) {
    $totalFilms = $db->query("SELECT COUNT(*) FROM films")->fetchColumn();
    $totalGallery = $db->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
    $totalMessages = $db->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'unread'")->fetchColumn();
    $upcomingEvents = $db->query("SELECT COUNT(*) FROM festival_schedule WHERE event_date >= CURDATE()")->fetchColumn();
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Dashboard</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo $totalFilms; ?></h3>
            <p>Total Films</p>
          </div>
          <div class="icon">
            <i class="fas fa-film"></i>
          </div>
          <a href="films/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?php echo $totalGallery; ?></h3>
            <p>Gallery Images</p>
          </div>
          <div class="icon">
            <i class="fas fa-images"></i>
          </div>
          <a href="gallery/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?php echo $upcomingEvents; ?></h3>
            <p>Upcoming Events</p>
          </div>
          <div class="icon">
            <i class="fas fa-calendar-alt"></i>
          </div>
          <a href="festival/index.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?php echo $totalMessages; ?></h3>
            <p>Unread Messages</p>
          </div>
          <div class="icon">
            <i class="fas fa-envelope"></i>
          </div>
          <a href="messages.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title">Recently Added Films</h3>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                <tr>
                  <th>Poster</th>
                  <th>Title</th>
                  <th>Year</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                  $recentFilms = [];
                  if ($db) {
                      $stmt = $db->query("SELECT * FROM films ORDER BY created_at DESC LIMIT 5");
                      $recentFilms = $stmt->fetchAll();
                  }
                  if (empty($recentFilms)): ?>
                      <tr><td colspan="5" class="text-center text-muted py-4">No films added yet.</td></tr>
                  <?php else: foreach($recentFilms as $film): ?>
                  <tr>
                      <td><img src="<?php echo strpos($film['poster'], 'http') === 0 ? $film['poster'] : '../assets/uploads/posters/'.$film['poster']; ?>" class="rounded" width="40" height="60" style="object-fit: cover;" onerror="this.src='../assets/images/hero-bg.png'"></td>
                      <td>
                          <div class="font-weight-bold"><?php echo htmlspecialchars($film['title']); ?></div>
                          <small class="text-muted">Dir: <?php echo htmlspecialchars($film['director']); ?></small>
                      </td>
                      <td><?php echo $film['year']; ?></td>
                      <td><span class="badge badge-success">Active</span></td>
                      <td>
                          <a href="films/edit.php?id=<?php echo $film['id']; ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></a>
                          <a href="films/delete.php?id=<?php echo $film['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                      </td>
                  </tr>
                  <?php endforeach; endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4">
        <div class="card bg-gradient-dark">
          <div class="card-header">
            <h3 class="card-title">Quick Shortcuts</h3>
          </div>
          <div class="card-body">
            <a href="films/add.php" class="btn btn-block btn-outline-light text-left mb-2"><i class="fas fa-plus-circle mr-2"></i> Add New Film</a>
            <a href="gallery/add.php" class="btn btn-block btn-outline-light text-left mb-2"><i class="fas fa-image mr-2"></i> Upload Photos</a>
            <a href="festival/add.php" class="btn btn-block btn-outline-light text-left"><i class="fas fa-calendar-plus mr-2"></i> Add Event</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->

  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
