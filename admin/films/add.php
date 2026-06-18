<?php 
require_once '../includes/header.php';

if (!isAdminLoggedIn()) {
    redirect('../login.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $director = sanitize($_POST['director']);
    $year = intval($_POST['year']);
    $genre = sanitize($_POST['genre']);
    $duration = sanitize($_POST['duration']);
    $synopsis = sanitize($_POST['synopsis']);
    $age_rating = sanitize($_POST['age_rating'] ?? '');
    $rating_score = floatval($_POST['rating_score'] ?? 0);
    $rating_count = sanitize($_POST['rating_count'] ?? '');
    $popularity_score = intval($_POST['popularity_score'] ?? 0);
    $writers = sanitize($_POST['writers'] ?? '');
    $tagline = sanitize($_POST['tagline'] ?? '');
    $poster = ''; // Will handle file upload below
    $slug = createSlug($title) . '-' . time();

    if (empty($title) || empty($director)) {
        $error = "Title and Director are required.";
    } else {
        // Handle File Upload
        if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../assets/uploads/posters/';
            $fileExtension = pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
            $newFileName = $slug . '.' . $fileExtension;
            $uploadFilePath = $uploadDir . $newFileName;
            
            if (move_uploaded_file($_FILES['poster']['tmp_name'], $uploadFilePath)) {
                $poster = $newFileName;
            } else {
                $error = "Failed to upload poster image.";
            }
        }
        
        if (empty($error) && $db) {
            $stmt = $db->prepare("INSERT INTO films (title, slug, director, year, genre, duration, synopsis, poster, age_rating, rating_score, rating_count, popularity_score, writers, tagline) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$title, $slug, $director, $year, $genre, $duration, $synopsis, $poster, $age_rating, $rating_score, $rating_count, $popularity_score, $writers, $tagline])) {
                setFlash('success', 'Film added successfully.');
                redirect('index.php');
            } else {
                $error = "Failed to add film to database.";
            }
        }
    }
}
?>

<div class="sidebar">
    <div class="p-4 mb-3 border-bottom border-secondary border-opacity-25">
        <h4 class="fw-bold mb-0">IBIFF <span class="gold">INDIA</span></h4>
        <small class="text-muted">Admin Panel</small>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link" href="../dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        <a class="nav-link active" href="index.php"><i class="fas fa-film me-2"></i> Manage Films</a>
        <a class="nav-link" href="../gallery/index.php"><i class="fas fa-images me-2"></i> Manage Gallery</a>
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
        <h2 class="fw-bold">Add New Film</h2>
        <a href="index.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Back</a>
    </div>

    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card admin-card p-4">
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Film Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Director</label>
                    <input type="text" name="director" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Year</label>
                    <input type="number" name="year" class="form-control" value="2024" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Genre</label>
                    <input type="text" name="genre" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Duration</label>
                    <input type="text" name="duration" class="form-control" placeholder="e.g., 120 mins">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Poster Image</label>
                    <input type="file" name="poster" class="form-control" accept="image/*">
                    <small class="text-muted">Upload a poster image for the film.</small>
                </div>
                
                <h5 class="fw-bold mt-4 mb-3 border-bottom pb-2">IMDb Style Metadata</h5>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Writers</label>
                    <input type="text" name="writers" class="form-control" placeholder="e.g., John Doe, Jane Smith">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tagline</label>
                    <input type="text" name="tagline" class="form-control" placeholder="e.g., No mercy. No shame. No sequel.">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Age Rating</label>
                    <input type="text" name="age_rating" class="form-control" placeholder="e.g., 18, PG-13">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Rating Score</label>
                    <input type="number" step="0.1" name="rating_score" class="form-control" placeholder="e.g., 6.3">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Rating Count</label>
                    <input type="text" name="rating_count" class="form-control" placeholder="e.g., 326K">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Popularity Score</label>
                    <input type="number" name="popularity_score" class="form-control" placeholder="e.g., 523">
                </div>

                <div class="col-md-12 mb-4">
                    <label class="form-label fw-bold">Synopsis</label>
                    <textarea name="synopsis" class="form-control" rows="4"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-gold px-4 py-2">Save Film</button>
                </div>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
