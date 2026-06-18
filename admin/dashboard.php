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

<div class="sidebar">
    <div class="p-4 mb-3 border-bottom border-secondary border-opacity-25">
        <h4 class="fw-bold mb-0">IBIFF <span class="gold">INDIA</span></h4>
        <small class="text-muted">Admin Panel</small>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link active" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        <a class="nav-link" href="films/index.php"><i class="fas fa-film me-2"></i> Manage Films</a>
        <a class="nav-link" href="gallery/index.php"><i class="fas fa-images me-2"></i> Manage Gallery</a>
        <a class="nav-link" href="festival/index.php"><i class="fas fa-calendar-alt me-2"></i> Festival Schedule</a>
        <a class="nav-link" href="messages.php"><i class="fas fa-envelope me-2"></i> Messages</a>
        <a class="nav-link" href="settings.php"><i class="fas fa-cog me-2"></i> Settings</a>
        <div class="mt-auto p-4">
            <a class="btn btn-outline-danger btn-sm w-100" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </div>
    </nav>
</div>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold">Welcome, <?php echo $_SESSION['admin_name']; ?></h2>
            <p class="text-muted mb-0">Here's what's happening with the festival today.</p>
        </div>
        <div>
            <button class="btn btn-gold"><i class="fas fa-plus me-2"></i> Add New Film</button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card admin-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="fas fa-film text-primary h4 mb-0"></i>
                    </div>
                    <span class="badge bg-success">+12%</span>
                </div>
                <h3 class="fw-bold"><?php echo $totalFilms; ?></h3>
                <p class="text-muted mb-0 small uppercase">Total Films</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card admin-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="fas fa-images text-warning h4 mb-0"></i>
                    </div>
                    <span class="badge bg-success">+5%</span>
                </div>
                <h3 class="fw-bold"><?php echo $totalGallery; ?></h3>
                <p class="text-muted mb-0 small uppercase">Gallery Images</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card admin-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3">
                        <i class="fas fa-calendar-check text-info h4 mb-0"></i>
                    </div>
                </div>
                <h3 class="fw-bold"><?php echo $upcomingEvents; ?></h3>
                <p class="text-muted mb-0 small uppercase">Upcoming Events</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card admin-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                        <i class="fas fa-envelope text-danger h4 mb-0"></i>
                    </div>
                    <span class="badge bg-danger">New</span>
                </div>
                <h3 class="fw-bold"><?php echo $totalMessages; ?></h3>
                <p class="text-muted mb-0 small uppercase">Contact Messages</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity / Recent Films -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card admin-card p-4">
                <h5 class="fw-bold mb-4">Recently Added Films</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
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
                                    <div class="fw-bold"><?php echo htmlspecialchars($film['title']); ?></div>
                                    <small class="text-muted">Dir: <?php echo htmlspecialchars($film['director']); ?></small>
                                </td>
                                <td><?php echo $film['year']; ?></td>
                                <td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
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
        <div class="col-lg-4">
            <div class="card admin-card p-4">
                <h5 class="fw-bold mb-4">Quick Shortcuts</h5>
                <div class="d-grid gap-2">
                    <a href="films/add.php" class="btn btn-outline-dark text-start p-3"><i class="fas fa-plus-circle me-2"></i> Add New Film</a>
                    <a href="gallery/add.php" class="btn btn-outline-dark text-start p-3"><i class="fas fa-image me-2"></i> Upload Photos</a>
                    <a href="festival/add.php" class="btn btn-outline-dark text-start p-3"><i class="fas fa-calendar-plus me-2"></i> Add Event</a>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
