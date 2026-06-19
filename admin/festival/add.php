<?php 
require_once '../includes/header.php';



$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $event_date = sanitize($_POST['event_date']);
    $start_time = sanitize($_POST['start_time']);
    $end_time = sanitize($_POST['end_time']);
    $venue = sanitize($_POST['venue']);
    $hall = sanitize($_POST['hall']);
    $description = sanitize($_POST['description']);

    if (empty($title) || empty($event_date) || empty($start_time)) {
        $error = "Title, Date, and Start Time are required.";
    } else {
        if ($db) {
            $tickets_url = sanitize($_POST['tickets_url'] ?? '');
            $map_embed_url = sanitize($_POST['map_embed_url'] ?? '');
            $directions = sanitize($_POST['directions'] ?? '');
            $organizer = sanitize($_POST['organizer'] ?? '');
            $organizer_partner = sanitize($_POST['organizer_partner'] ?? '');

            try {
                $stmt = $db->prepare("INSERT INTO festival_schedule (title, event_date, start_time, end_time, venue, hall, description, tickets_url, map_embed_url, directions, organizer, organizer_partner) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $success = $stmt->execute([$title, $event_date, $start_time, $end_time, $venue, $hall, $description, $tickets_url, $map_embed_url, $directions, $organizer, $organizer_partner]);
            } catch (PDOException $e) {
                if ($e->getCode() == '42S22') {
                    $columns = [
                        'tickets_url' => 'VARCHAR(255)', 'map_embed_url' => 'VARCHAR(1000)',
                        'directions' => 'TEXT', 'organizer' => 'VARCHAR(255)',
                        'organizer_partner' => 'VARCHAR(255)'
                    ];
                    foreach ($columns as $col => $type) {
                        try { $db->exec("ALTER TABLE festival_schedule ADD COLUMN $col $type"); } catch (PDOException $e2) { }
                    }
                    try { $db->exec("CREATE TABLE IF NOT EXISTS festival_sponsors (id INT AUTO_INCREMENT PRIMARY KEY, festival_id INT NOT NULL, logo_path VARCHAR(255) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)"); } catch (PDOException $e2) { }
                    
                    try {
                        $stmt = $db->prepare("INSERT INTO festival_schedule (title, event_date, start_time, end_time, venue, hall, description, tickets_url, map_embed_url, directions, organizer, organizer_partner) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $success = $stmt->execute([$title, $event_date, $start_time, $end_time, $venue, $hall, $description, $tickets_url, $map_embed_url, $directions, $organizer, $organizer_partner]);
                    } catch (PDOException $e3) {
                        $error = "DB Error: " . $e3->getMessage();
                        $success = false;
                    }
                } else {
                    $error = "DB Error: " . $e->getMessage();
                    $success = false;
                }
            }

            if ($success) {
                $festival_id = $db->lastInsertId();

                // Process Sponsor Logos
                if (isset($_FILES['sponsor_logos'])) {
                    $albumDir = __DIR__ . '/../../assets/uploads/sponsors/';
                    if (!file_exists($albumDir)) { mkdir($albumDir, 0777, true); }
                    
                    try {
                        $stmtPhoto = $db->prepare("INSERT INTO festival_sponsors (festival_id, logo_path) VALUES (?, ?)");
                        foreach ($_FILES['sponsor_logos']['tmp_name'] as $key => $tmpName) {
                            if (!empty($tmpName) && $_FILES['sponsor_logos']['error'][$key] === UPLOAD_ERR_OK) {
                                $fileExt = strtolower(pathinfo($_FILES['sponsor_logos']['name'][$key], PATHINFO_EXTENSION));
                                $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                                if (in_array($fileExt, $allowedExts)) {
                                    $newPhotoName = 'sponsor-' . time() . '-' . $key . '.' . $fileExt;
                                    $targetPath = $albumDir . $newPhotoName;
                                    if (move_uploaded_file($tmpName, $targetPath)) {
                                        $stmtPhoto->execute([$festival_id, 'assets/uploads/sponsors/' . $newPhotoName]);
                                    }
                                }
                            }
                        }
                    } catch (PDOException $e) { } // Ignore missing table error if they didn't auto-migrate properly
                }

                setFlash('success', 'Event added successfully.');
                redirect('index.php');
            }
        }
    }
}
?>

<section class="content"><div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Add New Event</h2>
        <a href="index.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Back</a>
    </div>

    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card card p-4">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 mb-3"><h5 class="fw-bold border-bottom pb-2">Basic Info</h5></div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Event Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Event Date <span class="text-danger">*</span></label>
                    <input type="date" name="event_date" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Start Time <span class="text-danger">*</span></label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">End Time</label>
                    <input type="time" name="end_time" class="form-control">
                </div>
                <div class="col-md-12 mb-4">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="col-md-12 mt-3 mb-3"><h5 class="fw-bold border-bottom pb-2">Ticketing & Location</h5></div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Buy Tickets URL</label>
                    <input type="url" name="tickets_url" class="form-control" placeholder="https://...">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Google Map URL</label>
                    <input type="url" name="map_embed_url" class="form-control" placeholder="Embed URL or Regular Link">
                    <small class="text-muted">Supports <code>google.com/maps/embed</code> or regular links.</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Venue Name</label>
                    <input type="text" name="venue" class="form-control" placeholder="e.g. Main Auditorium">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Hall / Room</label>
                    <input type="text" name="hall" class="form-control" placeholder="e.g. Hall A">
                </div>
                <div class="col-md-12 mb-4">
                    <label class="form-label fw-bold">Directions for Users</label>
                    <textarea name="directions" class="form-control" rows="2" placeholder="e.g. Enter through the East Gate..."></textarea>
                </div>

                <div class="col-md-12 mt-3 mb-3"><h5 class="fw-bold border-bottom pb-2">Organizers & Sponsors</h5></div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Organizer</label>
                    <input type="text" name="organizer" class="form-control" placeholder="e.g. IBIFF India">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Organizer Partner</label>
                    <input type="text" name="organizer_partner" class="form-control" placeholder="e.g. Film Society">
                </div>
                <div class="col-md-12 mb-4">
                    <label class="form-label fw-bold">Sponsored Brands Logos</label>
                    <input type="file" name="sponsor_logos[]" class="form-control" multiple accept="image/*">
                    <small class="text-muted">You can select multiple images.</small>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-gold px-4 py-2"><i class="fas fa-save me-2"></i> Save Event</button>
                </div>
            </div>
        </form>
    </div>
</div></section>
<?php require_once '../includes/footer.php'; ?>
