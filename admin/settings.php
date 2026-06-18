<?php
require_once 'includes/header.php';

if (!isAdminLoggedIn()) {
    redirect('login.php');
}

$successMessage = '';
$errorMessage = '';

// Handle Settings Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db->beginTransaction();

        // 1. Update text/textarea settings
        if (isset($_POST['settings']) && is_array($_POST['settings'])) {
            $stmt = $db->prepare("UPDATE site_settings SET setting_value = :val WHERE setting_key = :key");
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

            $stmtImg = $db->prepare("UPDATE site_settings SET setting_value = :val WHERE setting_key = :key");

            foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                if (!empty($tmpName) && $_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $fileName = $_FILES['images']['name'][$key];
                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

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
        $successMessage = "Settings updated successfully!";
    } catch (Exception $e) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        $errorMessage = "Error saving settings: " . $e->getMessage();
    }
}

// Fetch all settings
$settings = [];
if ($db) {
    $stmt = $db->query("SELECT * FROM site_settings ORDER BY setting_section, id");
    $allSettings = $stmt->fetchAll();
    
    // Group settings by section
    foreach ($allSettings as $setting) {
        $settings[$setting['setting_section']][] = $setting;
    }
}
?>

<div class="sidebar">
    <div class="p-4 mb-3 border-bottom border-secondary border-opacity-25">
        <h4 class="fw-bold mb-0">IBIFF <span class="gold">INDIA</span></h4>
        <small class="text-muted">Admin Panel</small>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        <a class="nav-link" href="films/index.php"><i class="fas fa-film me-2"></i> Manage Films</a>
        <a class="nav-link" href="gallery/index.php"><i class="fas fa-images me-2"></i> Manage Gallery</a>
        <a class="nav-link" href="festival/index.php"><i class="fas fa-calendar-alt me-2"></i> Festival Schedule</a>
        <a class="nav-link" href="messages.php"><i class="fas fa-envelope me-2"></i> Messages</a>
        <a class="nav-link active" href="settings.php"><i class="fas fa-cog me-2"></i> Settings</a>
        <div class="mt-auto p-4">
            <a class="btn btn-outline-danger btn-sm w-100" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </div>
    </nav>
</div>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold"><i class="fas fa-cogs me-3 text-warning"></i>Homepage Settings</h2>
            <p class="text-muted mb-0">Modify any text, list, dates, or assets visible on the website homepage.</p>
        </div>
        <div>
            <a href="../index.php" target="_blank" class="btn btn-outline-dark"><i class="fas fa-external-link-alt me-2"></i> View Homepage</a>
        </div>
    </div>

    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?php echo $successMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?php echo $errorMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <!-- Navigation Tabs -->
        <ul class="nav nav-pills mb-4 border-bottom pb-3 flex-nowrap" style="overflow-x: auto; white-space: nowrap;" id="settingsTabs" role="tablist">
            <?php 
            $sections = array_keys($settings);
            $activeClass = 'active';
            foreach ($sections as $sec):
            ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo $activeClass; ?>" id="<?php echo strtolower(str_replace(' ', '', $sec)); ?>-tab" data-bs-toggle="pill" data-bs-target="#<?php echo strtolower(str_replace(' ', '', $sec)); ?>" type="button" role="tab" aria-controls="<?php echo strtolower(str_replace(' ', '', $sec)); ?>" aria-selected="<?php echo $activeClass ? 'true' : 'false'; ?>">
                        <?php echo $sec; ?>
                    </button>
                </li>
            <?php 
                $activeClass = ''; 
            endforeach; 
            ?>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content" id="settingsTabsContent">
            <?php 
            $activeClass = 'show active';
            foreach ($sections as $sec):
                $secSettings = isset($settings[$sec]) ? $settings[$sec] : [];
            ?>
                <div class="tab-pane fade <?php echo $activeClass; ?>" id="<?php echo strtolower(str_replace(' ', '', $sec)); ?>" role="tabpanel" aria-labelledby="<?php echo strtolower(str_replace(' ', '', $sec)); ?>-tab">
                    <div class="card admin-card p-4 mb-4">
                        <h5 class="fw-bold mb-4 border-bottom pb-2"><?php echo $sec; ?> Configurations</h5>
                        <div class="row g-4">
                            <?php foreach ($secSettings as $setting): ?>
                                <div class="col-12 <?php echo ($setting['setting_type'] === 'textarea') ? 'col-lg-12' : 'col-lg-6'; ?>">
                                    <label class="form-label fw-semibold text-dark"><?php echo htmlspecialchars($setting['setting_label']); ?></label>
                                    <small class="text-muted d-block mb-2">Key: <code><?php echo htmlspecialchars($setting['setting_key']); ?></code></small>
                                    
                                    <?php if ($setting['setting_type'] === 'image'): ?>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="border rounded bg-light p-2" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                                <?php if (!empty($setting['setting_value'])): ?>
                                                    <img src="../<?php echo htmlspecialchars($setting['setting_value']); ?>" class="img-fluid rounded" style="max-height: 100%; object-fit: contain;" alt="Preview">
                                                <?php else: ?>
                                                    <span class="text-muted small">No Image</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex-grow-1">
                                                <input type="file" name="images[<?php echo htmlspecialchars($setting['setting_key']); ?>]" class="form-control" accept="image/*">
                                                <small class="text-muted d-block mt-1">Allowed formats: JPG, PNG, WEBP, GIF</small>
                                            </div>
                                        </div>
                                    <?php elseif ($setting['setting_type'] === 'textarea'): ?>
                                        <textarea name="settings[<?php echo htmlspecialchars($setting['setting_key']); ?>]" class="form-control" rows="4"><?php echo htmlspecialchars($setting['setting_value']); ?></textarea>
                                    <?php else: ?>
                                        <input type="text" name="settings[<?php echo htmlspecialchars($setting['setting_key']); ?>]" class="form-control" value="<?php echo htmlspecialchars($setting['setting_value']); ?>">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php 
                $activeClass = ''; 
            endforeach; 
            ?>
        </div>

        <!-- Submit Button -->
        <div class="mt-4 mb-5 card admin-card p-3 d-flex flex-row justify-content-between align-items-center bg-white shadow-sm">
            <span class="text-muted small"><i class="fas fa-info-circle me-1"></i> Make sure to review all tabs before saving.</span>
            <button type="submit" class="btn btn-gold px-5 py-2 fw-bold"><i class="fas fa-save me-2"></i> Save Changes</button>
        </div>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
