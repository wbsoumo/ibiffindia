<?php 
require_once 'includes/db.php';
require_once 'includes/functions.php';

$name = isset($_GET['name']) ? sanitize($_GET['name']) : null;

if (!$name) {
    redirect('films.php');
}

$pageTitle = "Director Profile - " . $name;
require_once 'includes/header.php'; 
require_once 'includes/navbar.php'; 

// Find all films by this director in our database
$stmt = $db->prepare("SELECT * FROM films WHERE director = ? ORDER BY year DESC");
$stmt->execute([$name]);
$director_films = $stmt->fetchAll();

?>

<div class="bg-black text-white pb-5" style="min-height: 100vh; padding-top: 120px;">
    <div class="container">
        
        <!-- Director Header -->
        <div class="row align-items-center mb-5 border-bottom border-secondary border-opacity-25 pb-5">
            <div class="col-md-3 text-center text-md-start mb-4 mb-md-0">
                <div class="bg-dark d-inline-flex align-items-center justify-content-center rounded-circle border border-2 border-gold shadow-lg" style="width: 200px; height: 200px; overflow: hidden;">
                    <i class="fas fa-user-tie fa-5x text-muted opacity-50"></i>
                </div>
            </div>
            <div class="col-md-9 text-center text-md-start">
                <h1 class="display-3 fw-bold mb-2 text-uppercase" style="font-family: 'Barlow', sans-serif;"><?php echo $name; ?></h1>
                <p class="text-gold fw-bold letter-spacing-1 mb-4">AWARD-WINNING DIRECTOR & CINEMATOGRAPHER</p>
                <p class="fs-5 text-light opacity-75 max-w-700">
                    <?php echo $name; ?> is an acclaimed filmmaker known for a unique visionary style and compelling storytelling. Their work has been featured in major international festivals, bringing authentic narratives to the global stage.
                </p>
                <div class="d-flex gap-3 justify-content-center justify-content-md-start mt-4">
                    <a href="#" class="btn btn-outline-light rounded-circle" style="width:40px;height:40px;line-height:26px;"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-outline-light rounded-circle" style="width:40px;height:40px;line-height:26px;"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="btn btn-outline-light rounded-circle" style="width:40px;height:40px;line-height:26px;"><i class="fab fa-imdb"></i></a>
                </div>
            </div>
        </div>

        <!-- Filmography -->
        <div class="mb-5">
            <h3 class="fw-bold text-uppercase mb-4">Official <span class="red">Selection</span> Filmography</h3>
            
            <?php if (count($director_films) > 0): ?>
                <div class="row g-4">
                    <?php foreach($director_films as $f): ?>
                        <div class="col-md-4 col-lg-3">
                            <a href="film-details.php?slug=<?php echo $f['slug']; ?>" class="text-decoration-none">
                                <div class="card bg-dark text-white h-100 border-0 hover-scale">
                                    <img src="<?php echo strpos($f['poster'], 'http') === 0 ? $f['poster'] : 'assets/uploads/posters/'.$f['poster']; ?>" 
                                         class="card-img-top object-fit-cover" 
                                         style="height: 350px;" 
                                         alt="<?php echo $f['title']; ?>"
                                         onerror="this.src='https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800'">
                                    <div class="card-body p-3">
                                        <h6 class="fw-bold text-white mb-1 text-truncate"><?php echo $f['title']; ?></h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted"><?php echo $f['year']; ?></small>
                                            <span class="badge bg-danger small"><?php echo $f['genre']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-muted">No films found for this director in the current selection.</p>
            <?php endif; ?>
        </div>

    </div>
</div>

<style>
.object-fit-cover { object-fit: cover; }
.letter-spacing-1 { letter-spacing: 1px; }
.hover-scale { transition: transform 0.3s ease; }
.hover-scale:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.5); }
</style>

<?php require_once 'includes/footer.php'; ?>
