<?php
require_once 'includes/header.php';

if (!isAdminLoggedIn()) {
    redirect('login.php');
}

$successMessage = '';
$errorMessage = '';

// Handle Welcome Settings Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db->beginTransaction();

        // 1. Update text/textarea settings
        if (isset($_POST['settings']) && is_array($_POST['settings'])) {
            $stmt = $db->prepare("UPDATE site_settings SET setting_value = :val WHERE setting_key = :key AND setting_section = 'Welcome'");
            foreach ($_POST['settings'] as $key => $value) {
                $stmt->execute([
                    ':val' => trim($value),
                    ':key' => $key
                ]);
            }
        }

        // 2. Handle Image Uploads
        if (isset($_FILES['images']) && is_array($_FILES['images']['tmp_name'])) {
            $uploadDir = __DIR__ . '/../assets/uploads/settings/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $stmtImg = $db->prepare("UPDATE site_settings SET setting_value = :val WHERE setting_key = :key AND setting_section = 'Welcome'");

            foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                if (!empty($tmpName) && $_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $fileName = $_FILES['images']['name'][$key];
                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'ico'];

                    if (in_array($fileExt, $allowedExts)) {
                        $newFileName = $key . '_' . time() . '.' . $fileExt;
                        $targetPath = $uploadDir . $newFileName;

                        if (move_uploaded_file($tmpName, $targetPath)) {
                            // Store relative path in DB
                            $dbPath = 'assets/uploads/settings/' . $newFileName;
                            $stmtImg->execute([
                                ':val' => $dbPath,
                                ':key' => $key
                            ]);
                        }
                    } else {
                        throw new Exception("Invalid file type for image setting: " . htmlspecialchars($key));
                    }
                }
            }
        }

        $db->commit();
        $successMessage = "Welcome section updated successfully!";
    } catch (Exception $e) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        $errorMessage = "Error saving settings: " . $e->getMessage();
    }
}

// Fetch all settings belonging to Welcome section
$welcomeSettings = [];
if ($db) {
    $stmt = $db->prepare("SELECT * FROM site_settings WHERE setting_section = 'Welcome' ORDER BY id");
    $stmt->execute();
    $welcomeSettings = $stmt->fetchAll();
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="fas fa-home text-warning mr-2"></i>Edit Welcome Section</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Welcome Section</li>
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

    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-ban"></i> <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Homepage Welcome & Committee Settings</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($welcomeSettings as $setting): ?>
                        <div class="col-12 <?php echo ($setting['setting_type'] === 'textarea') ? 'col-lg-12' : 'col-lg-6'; ?> mb-4">
                            <div class="form-group">
                                <label class="text-dark font-weight-bold"><?php echo htmlspecialchars($setting['setting_label']); ?></label>
                                <small class="text-muted d-block mb-2">Key: <code><?php echo htmlspecialchars($setting['setting_key']); ?></code></small>
                                
                                <?php if ($setting['setting_type'] === 'image'): ?>
                                    <div class="d-flex align-items-center">
                                        <div class="border rounded bg-light p-2 mr-3 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; overflow: hidden;">
                                            <?php if (!empty($setting['setting_value'])): ?>
                                                <img src="../<?php echo htmlspecialchars($setting['setting_value']); ?>" class="img-fluid rounded" style="max-height: 100%; object-fit: contain;" alt="Preview">
                                            <?php else: ?>
                                                <span class="text-muted small">No Image</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="custom-file">
                                                <input type="file" name="images[<?php echo htmlspecialchars($setting['setting_key']); ?>]" class="custom-file-input" id="file_<?php echo htmlspecialchars($setting['setting_key']); ?>" accept="image/*">
                                                <label class="custom-file-label" for="file_<?php echo htmlspecialchars($setting['setting_key']); ?>">Choose file</label>
                                            </div>
                                            <small class="text-muted d-block mt-1">Allowed formats: JPG, PNG, WEBP, GIF</small>
                                        </div>
                                    </div>
                                <?php elseif ($setting['setting_type'] === 'textarea'): ?>
                                    <textarea name="settings[<?php echo htmlspecialchars($setting['setting_key']); ?>]" class="form-control" rows="4"><?php echo htmlspecialchars($setting['setting_value']); ?></textarea>
                                <?php else: ?>
                                    <input type="text" name="settings[<?php echo htmlspecialchars($setting['setting_key']); ?>]" class="form-control" value="<?php echo htmlspecialchars($setting['setting_value']); ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                <span class="text-muted small"><i class="fas fa-info-circle mr-1"></i> Make sure to review all fields before saving.</span>
                <button type="submit" class="btn btn-gold px-5 py-2"><i class="fas fa-save mr-2"></i> Save Changes</button>
            </div>
        </div>
    </form>

  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
<script>
$(function () {
  $('.custom-file-input').on('change',function(){
    var fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
  })
})
</script>
