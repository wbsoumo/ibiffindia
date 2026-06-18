<?php 
require_once '../includes/header.php';



$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $year = intval($_POST['year']);
    $image = ''; // Will handle file upload below

    if (empty($title)) {
        $error = "Title is required.";
    } else {
        // Handle File Upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../assets/uploads/gallery/';
            $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $newFileName = 'gallery_' . time() . '_' . uniqid() . '.' . $fileExtension;
            $uploadFilePath = $uploadDir . $newFileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFilePath)) {
                $image = $newFileName;
            } else {
                $error = "Failed to upload gallery image.";
            }
        } else {
            $error = "Image file is required.";
        }
        
        if (empty($error) && $db) {
            $stmt = $db->prepare("INSERT INTO gallery (title, year, image) VALUES (?, ?, ?)");
            if ($stmt->execute([$title, $year, $image])) {
                setFlash('success', 'Photo added successfully.');
                redirect('index.php');
            } else {
                $error = "Failed to add photo to database.";
            }
        }
    }
}
?>

<section class="content"><div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Upload Photo</h2>
        <a href="index.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Back</a>
    </div>

    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card card p-4">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Photo Title / Caption</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Edition Year</label>
                    <input type="number" name="year" class="form-control" value="2024" required>
                </div>
                <div class="col-md-12 mb-4">
                    <label class="form-label fw-bold">Image File</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                    <small class="text-muted">Upload a photo for the gallery.</small>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-gold px-4 py-2">Save Photo</button>
                </div>
            </div>
        </form>
    </div>
</div></section>
<?php require_once '../includes/footer.php'; ?>
