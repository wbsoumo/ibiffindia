<?php
require_once 'includes/header.php';

if (!isAdminLoggedIn()) {
    redirect('login.php');
}

$successMessage = '';
$errorMessage = '';

// Handle Image Uploads
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media'])) {
    $media_type = $_POST['media_type'] ?? '';
    if (in_array($media_type, ['slider', 'moment', 'partner'])) {
        $uploadDir = __DIR__ . '/../assets/uploads/homepage/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $stmtImg = $db->prepare("INSERT INTO homepage_media (media_type, file_path, display_order) VALUES (?, ?, ?)");
        
        // Get max order
        $orderStmt = $db->prepare("SELECT MAX(display_order) FROM homepage_media WHERE media_type = ?");
        $orderStmt->execute([$media_type]);
        $maxOrder = (int)$orderStmt->fetchColumn();

        foreach ($_FILES['media']['tmp_name'] as $key => $tmpName) {
            if (!empty($tmpName) && $_FILES['media']['error'][$key] === UPLOAD_ERR_OK) {
                $fileName = $_FILES['media']['name'][$key];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

                if (in_array($fileExt, $allowedExts)) {
                    $newFileName = $media_type . '_' . time() . '_' . $key . '.' . $fileExt;
                    $targetPath = $uploadDir . $newFileName;

                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $maxOrder++;
                        $dbPath = 'assets/uploads/homepage/' . $newFileName;
                        $stmtImg->execute([$media_type, $dbPath, $maxOrder]);
                    }
                }
            }
        }
        $successMessage = ucfirst($media_type) . " media uploaded successfully!";
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $db->prepare("SELECT file_path FROM homepage_media WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    
    if ($item) {
        $filePath = __DIR__ . '/../' . $item['file_path'];
        if (file_exists($filePath) && strpos($item['file_path'], 'assets/uploads') !== false) {
            unlink($filePath);
        }
        $db->prepare("DELETE FROM homepage_media WHERE id = ?")->execute([$id]);
        $successMessage = "Media deleted successfully!";
        // Redirect to clear URL params
        header("Location: homepage_media.php");
        exit();
    }
}

// Fetch Media
$media = [
    'slider' => [],
    'moment' => [],
    'partner' => []
];

if ($db) {
    $stmt = $db->query("SELECT * FROM homepage_media ORDER BY media_type, display_order ASC");
    $allMedia = $stmt->fetchAll();
    foreach ($allMedia as $item) {
        $media[$item['media_type']][] = $item;
    }
}
?>

<style>
    .sortable-grid { list-style-type: none; margin: 0; padding: 0; display: flex; flex-wrap: wrap; gap: 15px; }
    .sortable-grid li { position: relative; width: 200px; border: 1px solid #ccc; padding: 5px; background: #fff; cursor: move; border-radius: 5px; }
    .sortable-grid li img { width: 100%; height: 120px; object-fit: cover; border-radius: 3px; }
    .sortable-grid li .btn-delete { position: absolute; top: -10px; right: -10px; border-radius: 50%; padding: 0; width: 25px; height: 25px; line-height: 25px; text-align: center; }
</style>

<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="fas fa-photo-video text-warning mr-2"></i>Homepage Media</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Homepage Media</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-check"></i> <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <div class="card card-dark card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs flex-nowrap" id="mediaTabs" role="tablist" style="overflow-x: auto; white-space: nowrap;">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-slider" data-toggle="pill" href="#content-slider" role="tab">Hero Slider</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-moment" data-toggle="pill" href="#content-moment" role="tab">Moments & Memories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-partner" data-toggle="pill" href="#content-partner" role="tab">Proud Partners</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                
                <?php 
                $types = ['slider' => 'Hero Slider', 'moment' => 'Moments & Memories', 'partner' => 'Proud Partners'];
                $activeClass = 'show active';
                foreach ($types as $typeKey => $typeLabel):
                ?>
                <div class="tab-pane fade <?php echo $activeClass; ?>" id="content-<?php echo $typeKey; ?>" role="tabpanel">
                    
                    <h4 class="mb-4 pb-2 border-bottom"><?php echo $typeLabel; ?></h4>
                    
                    <!-- Upload Form -->
                    <form method="POST" enctype="multipart/form-data" class="mb-4 bg-light p-3 border rounded">
                        <input type="hidden" name="media_type" value="<?php echo $typeKey; ?>">
                        <div class="form-group">
                            <label>Upload New <?php echo $typeLabel; ?> (Multiple allowed)</label>
                            <input type="file" name="media[]" class="form-control-file" multiple accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-upload"></i> Upload</button>
                    </form>

                    <!-- Sortable Grid -->
                    <ul class="sortable-grid" data-type="<?php echo $typeKey; ?>">
                        <?php foreach ($media[$typeKey] as $m): ?>
                        <li id="media_<?php echo $m['id']; ?>">
                            <img src="<?php echo htmlspecialchars('../' . $m['file_path']); ?>" alt="Media">
                            <a href="homepage_media.php?delete=<?php echo $m['id']; ?>" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this image?');"><i class="fas fa-times"></i></a>
                        </li>
                        <?php endforeach; ?>
                        <?php if(empty($media[$typeKey])): ?>
                            <li style="width:100%; border:none; background:transparent; cursor:default; color:#666;">No images uploaded yet.</li>
                        <?php endif; ?>
                    </ul>

                </div>
                <?php $activeClass = ''; endforeach; ?>

            </div>
        </div>
    </div>

  </div>
</section>

<?php require_once 'includes/footer.php'; ?>

<!-- jQuery UI for Sortable -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(function() {
    $(".sortable-grid").sortable({
        update: function(event, ui) {
            var order = $(this).sortable('serialize');
            $.ajax({
                url: 'ajax_reorder_media.php',
                type: 'POST',
                data: order,
                success: function(response) {
                    // toastr.success('Order saved');
                }
            });
        }
    });
    $(".sortable-grid").disableSelection();
});
</script>
