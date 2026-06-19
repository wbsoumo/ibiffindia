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
            $trailer_url = sanitize($_POST['trailer_url'] ?? '');
            
            // New Extended Fields
            $directors_statement = sanitize($_POST['directors_statement'] ?? '');
            $cinematographer = sanitize($_POST['cinematographer'] ?? '');
            $composer = sanitize($_POST['composer'] ?? '');
            $editor = sanitize($_POST['editor'] ?? '');
            $production_company = sanitize($_POST['production_company'] ?? '');
            $press_quotes = sanitize($_POST['press_quotes'] ?? '');
            $budget = sanitize($_POST['budget'] ?? '');
            $filming_locations = sanitize($_POST['filming_locations'] ?? '');
            $aspect_ratio = sanitize($_POST['aspect_ratio'] ?? '');
            $sound_mix = sanitize($_POST['sound_mix'] ?? '');
            
            $stmt = $db->prepare("INSERT INTO films (title, slug, director, year, genre, duration, synopsis, poster, age_rating, rating_score, rating_count, popularity_score, writers, tagline, trailer_url, directors_statement, cinematographer, composer, editor, production_company, press_quotes, budget, filming_locations, aspect_ratio, sound_mix) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            try {
                $success = $stmt->execute([$title, $slug, $director, $year, $genre, $duration, $synopsis, $poster, $age_rating, $rating_score, $rating_count, $popularity_score, $writers, $tagline, $trailer_url, $directors_statement, $cinematographer, $composer, $editor, $production_company, $press_quotes, $budget, $filming_locations, $aspect_ratio, $sound_mix]);
            } catch (PDOException $e) {
                if ($e->getCode() == '42S22') {
                    $columns = [
                        'directors_statement' => 'TEXT', 'cinematographer' => 'VARCHAR(255)',
                        'composer' => 'VARCHAR(255)', 'editor' => 'VARCHAR(255)',
                        'production_company' => 'VARCHAR(255)', 'press_quotes' => 'TEXT',
                        'budget' => 'VARCHAR(100)', 'filming_locations' => 'VARCHAR(255)',
                        'aspect_ratio' => 'VARCHAR(50)', 'sound_mix' => 'VARCHAR(100)'
                    ];
                    foreach ($columns as $col => $type) {
                        try {
                            $db->exec("ALTER TABLE films ADD COLUMN $col $type");
                        } catch (PDOException $e2) { }
                    }
                    $success = $stmt->execute([$title, $slug, $director, $year, $genre, $duration, $synopsis, $poster, $age_rating, $rating_score, $rating_count, $popularity_score, $writers, $tagline, $trailer_url, $directors_statement, $cinematographer, $composer, $editor, $production_company, $press_quotes, $budget, $filming_locations, $aspect_ratio, $sound_mix]);
                } else {
                    $success = false;
                }
            }
            
            if ($success) {
                
                $film_id = $db->lastInsertId();

                // Process Album Photos
                if (isset($_FILES['album_photos'])) {
                    $albumDir = __DIR__ . '/../../assets/uploads/albums/';
                    if (!file_exists($albumDir)) {
                        mkdir($albumDir, 0777, true);
                    }
                    
                    $stmtPhoto = $db->prepare("INSERT INTO film_photos (film_id, photo_path) VALUES (?, ?)");
                    foreach ($_FILES['album_photos']['tmp_name'] as $key => $tmpName) {
                        if (!empty($tmpName) && $_FILES['album_photos']['error'][$key] === UPLOAD_ERR_OK) {
                            $fileExt = strtolower(pathinfo($_FILES['album_photos']['name'][$key], PATHINFO_EXTENSION));
                            $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                            
                            if (in_array($fileExt, $allowedExts)) {
                                $newPhotoName = $slug . '-album-' . time() . '-' . $key . '.' . $fileExt;
                                $targetPath = $albumDir . $newPhotoName;
                                if (move_uploaded_file($tmpName, $targetPath)) {
                                    $stmtPhoto->execute([$film_id, 'assets/uploads/albums/' . $newPhotoName]);
                                }
                            }
                        }
                    }
                }

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

                <!-- Extended Crew Card -->
                <div class="card card-dark mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Extended Cast & Crew</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cinematographer</label>
                                    <input type="text" name="cinematographer" class="form-control" placeholder="Director of Photography">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Composer / Music</label>
                                    <input type="text" name="composer" class="form-control" placeholder="Original Score">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Editor</label>
                                    <input type="text" name="editor" class="form-control" placeholder="Film Editor">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label>Director's Statement / Vision</label>
                            <textarea name="directors_statement" class="form-control" rows="4" placeholder="Personal message or vision from the director..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Production Details Card -->
                <div class="card card-dark mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Production & Press</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Production Company</label>
                                    <input type="text" name="production_company" class="form-control" placeholder="e.g., A24, Warner Bros">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Filming Locations</label>
                                    <input type="text" name="filming_locations" class="form-control" placeholder="e.g., London, UK; Paris, France">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Budget / Box Office</label>
                                    <input type="text" name="budget" class="form-control" placeholder="e.g., $15 Million">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Aspect Ratio</label>
                                    <input type="text" name="aspect_ratio" class="form-control" placeholder="e.g., 2.39:1">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sound Mix</label>
                                    <input type="text" name="sound_mix" class="form-control" placeholder="e.g., Dolby Atmos">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label>Press & Critic Quotes</label>
                            <textarea name="press_quotes" class="form-control" rows="3" placeholder="e.g., 'A masterpiece.' - The NY Times"></textarea>
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
                            <label>Poster Image <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" name="poster" class="custom-file-input" id="posterInput" accept="image/*" required>
                                <label class="custom-file-label" for="posterInput">Choose file</label>
                            </div>
                            <small class="text-muted mt-1 d-block">Recommended size: 600x900 pixels.</small>
                        </div>

                        <div class="form-group mt-3">
                            <label>Trailer URL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fab fa-youtube text-danger"></i></span>
                                </div>
                                <input type="url" name="trailer_url" class="form-control" placeholder="https://youtube.com/watch?v=...">
                            </div>
                            <small class="text-muted mt-1 d-block">YouTube link or direct video URL.</small>
                        </div>

                        <div class="form-group mt-3">
                            <label>Album Photos</label>
                            <div class="custom-file">
                                <input type="file" name="album_photos[]" class="custom-file-input" id="albumInput" accept="image/*" multiple>
                                <label class="custom-file-label" for="albumInput">Choose multiple files...</label>
                            </div>
                            <small class="text-muted mt-1 d-block">Upload multiple photos for the film gallery.</small>
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
    // Show selected file name in custom file input (Poster)
    var posterInput = document.getElementById('posterInput');
    if(posterInput) {
        posterInput.addEventListener('change', function(e){
            if (e.target.files.length > 0) {
                var fileName = e.target.files[0].name;
                var nextSibling = e.target.nextElementSibling;
                nextSibling.innerText = fileName;
            }
        });
    }

    // Show multiple files count in custom file input (Album)
    var albumInput = document.getElementById('albumInput');
    if(albumInput) {
        albumInput.addEventListener('change', function(e){
            var filesCount = e.target.files.length;
            var nextSibling = e.target.nextElementSibling;
            if (filesCount > 1) {
                nextSibling.innerText = filesCount + ' files selected';
            } else if (filesCount === 1) {
                nextSibling.innerText = e.target.files[0].name;
            } else {
                nextSibling.innerText = 'Choose multiple files...';
            }
        });
    }
});
</script>

<?php require_once '../includes/footer.php'; ?>
