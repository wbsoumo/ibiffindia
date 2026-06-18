<?php 
require_once '../includes/header.php';

if (!isAdminLoggedIn()) {
    redirect('../login.php');
}

$gallery = [];
if ($db) {
    $stmt = $db->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
    $gallery = $stmt->fetchAll();
}
?>

<div class="sidebar">
    <div class="p-4 mb-3 border-bottom border-secondary border-opacity-25">
        <h4 class="fw-bold mb-0">IBIFF <span class="gold">INDIA</span></h4>
        <small class="text-muted">Admin Panel</small>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link" href="../dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        <a class="nav-link" href="../films/index.php"><i class="fas fa-film me-2"></i> Manage Films</a>
        <a class="nav-link active" href="index.php"><i class="fas fa-images me-2"></i> Manage Gallery</a>
        <a class="nav-link" href="../festival/index.php"><i class="fas fa-calendar-alt me-2"></i> Festival Schedule</a>
        <a class="nav-link" href="../messages.php"><i class="fas fa-envelope me-2"></i> Messages</a>
        <a class="nav-link" href="../settings.php"><i class="fas fa-cog me-2"></i> Settings</a>
        <div class="mt-auto p-4">
            <a class="btn btn-outline-danger btn-sm w-100" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </div>
    </nav>
</div>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manage Gallery</h2>
        <a href="add.php" class="btn btn-gold"><i class="fas fa-upload me-2"></i> Upload Photo</a>
    </div>

    <?php if($msg = getFlash('success')): ?>
        <div class="alert alert-success"><?php echo $msg; ?></div>
    <?php endif; ?>

    <div class="card admin-card p-4">
        <div class="row g-4">
            <?php if(empty($gallery)): ?>
                <div class="col-12 text-center text-muted py-4">No photos found.</div>
            <?php else: foreach($gallery as $img): ?>
                <div class="col-md-3">
                    <div class="card bg-dark text-white border-0 h-100">
                        <img src="<?php echo strpos($img['image'], 'http') === 0 ? $img['image'] : '../../assets/uploads/gallery/'.$img['image']; ?>" class="card-img-top" style="height: 150px; object-fit: cover;" onerror="this.src='../../assets/images/hero-bg.png'">
                        <div class="card-body p-2">
                            <h6 class="card-title text-truncate mb-1"><?php echo htmlspecialchars($img['title']); ?></h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><?php echo $img['year']; ?></small>
                                <a href="delete.php?id=<?php echo $img['id']; ?>" class="btn btn-sm btn-danger py-0 px-2" onclick="return confirm('Are you sure you want to delete this photo?');"><i class="fas fa-trash small"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
