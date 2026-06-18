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
    
    // Auto-seed if empty
    if (empty($allSettings)) {
        $defaultSettings = [
            ['site_logo', 'assets/images/logo.png', 'image', 'Site Logo (Navbar)', 'General Settings'],
            ['site_favicon', 'assets/images/favicon.ico', 'image', 'Site Favicon', 'General Settings'],
            ['meta_title', 'IBIFF INDIA | Indo-Bangla International Film Festival', 'text', 'Meta Title', 'General Settings'],
            ['meta_description', 'Celebrating Cross-Border Cinema and connecting cultures through storytelling.', 'textarea', 'Meta Description', 'General Settings'],
            
            ['about_tagline', 'Bridging the cinematic gap between India and Bangladesh.', 'text', 'About Us Tagline', 'Page - About'],
            ['about_history_title', 'THE HEART OF IBIFF INDIA', 'text', 'History Title', 'Page - About'],
            ['about_history_text', 'Founded with a passion for storytelling...', 'textarea', 'History Text', 'Page - About'],
            
            ['slider_img_1', 'https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=1920', 'image', 'Slider Image 1', 'Page - Homepage'],
            ['slider_img_2', 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=1920', 'image', 'Slider Image 2', 'Page - Homepage'],
            ['slider_img_3', 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=1920', 'image', 'Slider Image 3', 'Page - Homepage'],
            ['submit_film_link', 'https://filmfreeway.com', 'text', 'Submit Film Button Link', 'Page - Homepage'],
            
            ['mission_tag', 'Our Vision', 'text', 'Vision Tag', 'Page - Homepage'],
            ['mission_title', 'BRIDGING CULTURES THROUGH CINEMA', 'text', 'Vision Title', 'Page - Homepage'],
            ['mission_subtitle', 'Uniting filmmakers, storytellers, and diverse audiences from across the globe under one roof.', 'textarea', 'Vision Subtitle', 'Page - Homepage'],
            ['mission_text', 'The International Indo-Bangla Film Festival (IBIFF) is a premier platform dedicated to showcasing the finest independent cinema.', 'textarea', 'Vision Text', 'Page - Homepage'],
            ['mission_image', 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?q=80&w=800', 'image', 'Vision Image', 'Page - Homepage'],
            
            ['why_tag', 'Why Join Us?', 'text', 'Why Tag', 'Page - Homepage'],
            ['why_title', 'A PLATFORM FOR VISIONARIES', 'text', 'Why Title', 'Page - Homepage'],
            ['why_subtitle', 'Elevate your filmmaking career by participating in a festival that truly values artistic merit, storytelling innovation, and impactful narratives.', 'textarea', 'Why Subtitle', 'Page - Homepage'],
            ['why_item_1_title', 'International Exposure', 'text', 'Why Item 1 Title', 'Page - Homepage'],
            ['why_item_1_desc', 'Your film will be showcased to a diverse audience and top industry executives.', 'text', 'Why Item 1 Desc', 'Page - Homepage'],
            ['why_item_2_title', 'Valuable Networking', 'text', 'Why Item 2 Title', 'Page - Homepage'],
            ['why_item_2_desc', 'Connect with established directors, producers, and potential distributors.', 'text', 'Why Item 2 Desc', 'Page - Homepage'],
            ['why_item_3_title', 'Prestigious Awards', 'text', 'Why Item 3 Title', 'Page - Homepage'],
            ['why_item_3_desc', 'Compete for globally recognized accolades and cash prizes.', 'text', 'Why Item 3 Desc', 'Page - Homepage'],
            ['why_item_4_title', 'Masterclasses', 'text', 'Why Item 4 Title', 'Page - Homepage'],
            ['why_item_4_desc', 'Learn from the best in the business through exclusive interactive sessions.', 'text', 'Why Item 4 Desc', 'Page - Homepage'],
            
            ['moments_title', 'MOMENTS & MEMORIES', 'text', 'Memories Title', 'Page - Homepage'],
            ['moments_img_1', 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=600', 'image', 'Memory Photo 1', 'Page - Homepage'],
            ['moments_img_2', 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=600', 'image', 'Memory Photo 2', 'Page - Homepage'],
            ['moments_img_3', 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=600', 'image', 'Memory Photo 3', 'Page - Homepage'],
            ['moments_img_4', 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?q=80&w=600', 'image', 'Memory Photo 4', 'Page - Homepage'],
            
            ['partner_img_1', '', 'image', 'Partner Logo 1', 'Page - Homepage'],
            ['partner_img_2', '', 'image', 'Partner Logo 2', 'Page - Homepage'],
            ['partner_img_3', '', 'image', 'Partner Logo 3', 'Page - Homepage'],
            ['partner_img_4', '', 'image', 'Partner Logo 4', 'Page - Homepage'],
            ['partner_img_5', '', 'image', 'Partner Logo 5', 'Page - Homepage'],
            ['partner_img_6', '', 'image', 'Partner Logo 6', 'Page - Homepage']
        ];
        $insertStmt = $db->prepare("INSERT IGNORE INTO site_settings (setting_key, setting_value, setting_type, setting_label, setting_section) VALUES (?, ?, ?, ?, ?)");
        foreach ($defaultSettings as $ds) {
            $insertStmt->execute($ds);
        }
        // Refresh settings after seeding
        $stmt = $db->query("SELECT * FROM site_settings ORDER BY setting_section, id");
        $allSettings = $stmt->fetchAll();
        $successMessage = "Database seeded automatically! You can now manage settings.";
    }
    
    // Group settings by section
    foreach ($allSettings as $setting) {
        $settings[$setting['setting_section']][] = $setting;
    }
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="fas fa-cogs text-warning mr-2"></i>Website CMS</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Settings</li>
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
        <div class="card card-dark card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs flex-nowrap" id="settingsTabs" role="tablist" style="overflow-x: auto; white-space: nowrap;">
                    <?php 
                    $sections = array_keys($settings);
                    $activeClass = 'active';
                    foreach ($sections as $sec):
                        $tabId = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $sec));
                    ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $activeClass; ?>" id="tab-<?php echo $tabId; ?>" data-toggle="pill" href="#content-<?php echo $tabId; ?>" role="tab" aria-controls="content-<?php echo $tabId; ?>" aria-selected="<?php echo $activeClass ? 'true' : 'false'; ?>">
                                <?php echo htmlspecialchars($sec); ?>
                            </a>
                        </li>
                    <?php 
                        $activeClass = ''; 
                    endforeach; 
                    ?>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="settingsTabsContent">
                    <?php 
                    $activeClass = 'show active';
                    foreach ($sections as $sec):
                        $secSettings = isset($settings[$sec]) ? $settings[$sec] : [];
                        $tabId = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $sec));
                    ?>
                        <div class="tab-pane fade <?php echo $activeClass; ?>" id="content-<?php echo $tabId; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $tabId; ?>">
                            <h4 class="mb-4 pb-2 border-bottom"><?php echo htmlspecialchars($sec); ?> Configurations</h4>
                            <div class="row">
                                <?php foreach ($secSettings as $setting): ?>
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
                    <?php 
                        $activeClass = ''; 
                    endforeach; 
                    ?>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                <span class="text-muted small"><i class="fas fa-info-circle mr-1"></i> Make sure to review all tabs before saving.</span>
                <button type="submit" class="btn btn-gold px-5 py-2"><i class="fas fa-save mr-2"></i> Save Changes</button>
            </div>
        </div>
    </form>

  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
<script>
// Update custom file input label on selection
$(function () {
  $('.custom-file-input').on('change',function(){
    var fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
  })
})
</script>
