<?php 
require_once '../includes/header.php';



$gallery = [];
if ($db) {
    $stmt = $db->query("SELECT * FROM gallery ORDER BY uploaded_at DESC");
    $gallery = $stmt->fetchAll();
}
?>

<section class="content"><div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manage Gallery</h2>
        <a href="add.php" class="btn btn-gold"><i class="fas fa-upload me-2"></i> Upload Photo</a>
    </div>

    <?php if($msg = getFlash('success')): ?>
        <div class="alert alert-success"><?php echo $msg; ?></div>
    <?php endif; ?>

    <div class="card card p-4">
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
</div></section>
<?php require_once '../includes/footer.php'; ?>
