<?php 
require_once '../includes/header.php';



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

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="fas fa-film text-warning mr-2"></i>Add New Film</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="../dashboard.php">Home</a></li>
          <li class="breadcrumb-item"><a href="index.php">Manage Films</a></li>
          <li class="breadcrumb-item active">Add Film</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <?php if($error): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-ban"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <!-- Left Column: Core Info -->
            <div class="col-md-8">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Core Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Film Title <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                </div>
                                <input type="text" name="title" class="form-control" placeholder="Enter film title" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Director <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-director"></i><i class="fas fa-video"></i></span>
                                        </div>
                                        <input type="text" name="director" class="form-control" placeholder="Director name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Writers</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pen-nib"></i></span>
                                        </div>
                                        <input type="text" name="writers" class="form-control" placeholder="e.g., John Doe, Jane Smith">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Release Year <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="number" name="year" class="form-control" value="<?php echo date('Y'); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Genre</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-masks-theater"></i><i class="fas fa-theater-masks"></i></span>
                                        </div>
                                        <input type="text" name="genre" class="form-control" placeholder="e.g., Drama, Thriller">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Duration</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <input type="text" name="duration" class="form-control" placeholder="e.g., 120 mins">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Tagline</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-quote-left"></i></span>
                                </div>
                                <input type="text" name="tagline" class="form-control" placeholder="Catchy phrase or quote">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Synopsis</label>
                            <textarea name="synopsis" class="form-control" rows="5" placeholder="Write a compelling synopsis..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Media & Meta -->
            <div class="col-md-4">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Media & Ratings</h3>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label>Poster Image</label>
                            <div class="custom-file">
                                <input type="file" name="poster" class="custom-file-input" id="posterInput" accept="image/*">
                                <label class="custom-file-label" for="posterInput">Choose file</label>
                            </div>
                            <small class="text-muted mt-1 d-block">Recommended size: 600x900 pixels.</small>
                        </div>

                        <hr>
                        <label class="text-muted text-uppercase small font-weight-bold">IMDb Style Metadata</label>

                        <div class="form-group mt-2">
                            <label>Age Rating</label>
                            <input type="text" name="age_rating" class="form-control" placeholder="e.g., 18, PG-13">
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Rating Score</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="rating_score" class="form-control" placeholder="6.3">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-star text-warning"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Popularity Score</label>
                                    <input type="number" name="popularity_score" class="form-control" placeholder="523">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Total Rating Count</label>
                            <input type="text" name="rating_count" class="form-control" placeholder="e.g., 326K">
                        </div>

                    </div>
                    <div class="card-footer bg-white text-right">
                        <a href="index.php" class="btn btn-default mr-2">Cancel</a>
                        <button type="submit" class="btn btn-warning font-weight-bold"><i class="fas fa-save mr-1"></i> Publish Film</button>
                    </div>
                </div>
            </div>

        </div>
    </form>
  </div>
</section>

<!-- Custom Script for File Input -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Show selected file name in custom file input
    var posterInput = document.getElementById('posterInput');
    if(posterInput) {
        posterInput.addEventListener('change', function(e){
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling
            nextSibling.innerText = fileName
        });
    }
});
</script>

<?php require_once '../includes/footer.php'; ?>
