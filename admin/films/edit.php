<?php 
require_once '../includes/header.php';

$error = '';
$film_id = $_GET['id'] ?? null;

if (!$film_id) {
    redirect('index.php');
}

// Handle Photo Deletion
if (isset($_GET['delete_photo'])) {
    $photo_id = (int)$_GET['delete_photo'];
    $stmt = $db->prepare("SELECT photo_path FROM film_photos WHERE id = ? AND film_id = ?");
    $stmt->execute([$photo_id, $film_id]);
    $photo = $stmt->fetch();
    if ($photo) {
        $filePath = __DIR__ . '/../../' . $photo['photo_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $db->prepare("DELETE FROM film_photos WHERE id = ?")->execute([$photo_id]);
        setFlash('success', 'Photo deleted successfully.');
        redirect('edit.php?id=' . $film_id);
    }
}

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
    $trailer_url = sanitize($_POST['trailer_url'] ?? '');

    if (empty($title) || empty($director)) {
        $error = "Title and Director are required.";
    } else {
        // Handle Poster Upload
        $posterQuery = "";
        $params = [$title, $director, $year, $genre, $duration, $synopsis, $age_rating, $rating_score, $rating_count, $popularity_score, $writers, $tagline, $trailer_url];
        
        if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../assets/uploads/posters/';
            $fileExtension = pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
            $newFileName = createSlug($title) . '-' . time() . '.' . $fileExtension;
            $uploadFilePath = $uploadDir . $newFileName;
            
            if (move_uploaded_file($_FILES['poster']['tmp_name'], $uploadFilePath)) {
                $posterQuery = ", poster = ?";
                $params[] = $newFileName;
            } else {
                $error = "Failed to upload poster image.";
            }
        }
        
        if (empty($error) && $db) {
            $params[] = $film_id; // For WHERE clause
            $stmt = $db->prepare("UPDATE films SET title=?, director=?, year=?, genre=?, duration=?, synopsis=?, age_rating=?, rating_score=?, rating_count=?, popularity_score=?, writers=?, tagline=?, trailer_url=? $posterQuery WHERE id=?");
            
            if ($stmt->execute($params)) {
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
                                $newPhotoName = createSlug($title) . '-album-' . time() . '-' . $key . '.' . $fileExt;
                                $targetPath = $albumDir . $newPhotoName;
                                if (move_uploaded_file($tmpName, $targetPath)) {
                                    $stmtPhoto->execute([$film_id, 'assets/uploads/albums/' . $newPhotoName]);
                                }
                            }
                        }
                    }
                }

                setFlash('success', 'Film updated successfully.');
                redirect('index.php');
            } else {
                $error = "Failed to update film.";
            }
        }
    }
}

$stmt = $db->prepare("SELECT * FROM films WHERE id = ?");
$stmt->execute([$film_id]);
$film = $stmt->fetch();

if (!$film) {
    redirect('index.php');
}

$stmt = $db->prepare("SELECT * FROM film_photos WHERE film_id = ? ORDER BY created_at DESC");
$stmt->execute([$film_id]);
$photos = $stmt->fetchAll();

?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><i class="fas fa-edit text-warning mr-2"></i>Edit Film</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="../dashboard.php">Home</a></li>
          <li class="breadcrumb-item"><a href="index.php">Manage Films</a></li>
          <li class="breadcrumb-item active">Edit Film</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <?php if($msg = getFlash('success')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fas fa-check"></i> <?php echo $msg; ?>
        </div>
    <?php endif; ?>

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
                                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($film['title']); ?>" required>
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
                                        <input type="text" name="director" class="form-control" value="<?php echo htmlspecialchars($film['director']); ?>" required>
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
                                        <input type="text" name="writers" class="form-control" value="<?php echo htmlspecialchars($film['writers'] ?? ''); ?>">
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
                                        <input type="number" name="year" class="form-control" value="<?php echo htmlspecialchars($film['year']); ?>" required>
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
                                        <input type="text" name="genre" class="form-control" value="<?php echo htmlspecialchars($film['genre'] ?? ''); ?>">
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
                                        <input type="text" name="duration" class="form-control" value="<?php echo htmlspecialchars($film['duration'] ?? ''); ?>">
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
                                <input type="text" name="tagline" class="form-control" value="<?php echo htmlspecialchars($film['tagline'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Synopsis</label>
                            <textarea name="synopsis" class="form-control" rows="5"><?php echo htmlspecialchars($film['synopsis'] ?? ''); ?></textarea>
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
                        
                        <?php if ($film['poster']): ?>
                        <div class="mb-3 text-center">
                            <img src="../../assets/uploads/posters/<?php echo htmlspecialchars($film['poster']); ?>" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label>Update Poster Image</label>
                            <div class="custom-file">
                                <input type="file" name="poster" class="custom-file-input" id="posterInput" accept="image/*">
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
                                <input type="url" name="trailer_url" class="form-control" value="<?php echo htmlspecialchars($film['trailer_url'] ?? ''); ?>">
                            </div>
                            <small class="text-muted mt-1 d-block">YouTube link or direct video URL.</small>
                        </div>

                        <div class="form-group mt-3 border p-3 bg-light rounded">
                            <label><i class="fas fa-images mr-1"></i> Album Photos</label>
                            <?php if (!empty($photos)): ?>
                                <div class="d-flex flex-wrap gap-2 mb-3" style="gap: 10px;">
                                    <?php foreach ($photos as $p): ?>
                                    <div class="position-relative" style="width: 80px; height: 80px;">
                                        <img src="../../<?php echo htmlspecialchars($p['photo_path']); ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                                        <a href="edit.php?id=<?php echo $film['id']; ?>&delete_photo=<?php echo $p['id']; ?>" class="btn btn-danger btn-xs position-absolute" style="top: -5px; right: -5px; border-radius: 50%;" onclick="return confirm('Delete this photo?');"><i class="fas fa-times"></i></a>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="custom-file">
                                <input type="file" name="album_photos[]" class="custom-file-input" id="albumInput" accept="image/*" multiple>
                                <label class="custom-file-label" for="albumInput">Add multiple photos...</label>
                            </div>
                        </div>

                        <hr>
                        <label class="text-muted text-uppercase small font-weight-bold">IMDb Style Metadata</label>

                        <div class="form-group mt-2">
                            <label>Age Rating</label>
                            <input type="text" name="age_rating" class="form-control" value="<?php echo htmlspecialchars($film['age_rating'] ?? ''); ?>">
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Rating Score</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="rating_score" class="form-control" value="<?php echo htmlspecialchars($film['rating_score'] ?? ''); ?>">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-star text-warning"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Popularity Score</label>
                                    <input type="number" name="popularity_score" class="form-control" value="<?php echo htmlspecialchars($film['popularity_score'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Total Rating Count</label>
                            <input type="text" name="rating_count" class="form-control" value="<?php echo htmlspecialchars($film['rating_count'] ?? ''); ?>">
                        </div>

                    </div>
                    <div class="card-footer bg-white text-right">
                        <a href="index.php" class="btn btn-default mr-2">Cancel</a>
                        <button type="submit" class="btn btn-warning font-weight-bold"><i class="fas fa-save mr-1"></i> Update Film</button>
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
                nextSibling.innerText = 'Add multiple photos...';
            }
        });
    }
});
</script>

<?php require_once '../includes/footer.php'; ?>
