<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$slug = isset($_GET['slug']) ? sanitize($_GET['slug']) : null;
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$slug && !$id) {
    redirect('films.php');
}

// Fetch Film from DB
if ($slug) {
    $stmt = $db->prepare("SELECT * FROM films WHERE slug = ?");
    $stmt->execute([$slug]);
} else {
    $stmt = $db->prepare("SELECT * FROM films WHERE id = ?");
    $stmt->execute([$id]);
}
$film = $stmt->fetch();

if (!$film) {
    redirect('films.php');
}

// Fetch Album Photos
$album_photos = [];
try {
    $stmtPhotos = $db->prepare("SELECT photo_path FROM film_photos WHERE film_id = ? ORDER BY created_at ASC");
    if ($stmtPhotos) {
        $stmtPhotos->execute([$film['id']]);
        $album_photos = $stmtPhotos->fetchAll(PDO::FETCH_COLUMN);
    }
} catch (PDOException $e) {
    // If table doesn't exist, auto-create it to prevent 500 error
    $db->exec("CREATE TABLE IF NOT EXISTS film_photos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        film_id INT NOT NULL,
        photo_path VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
}

$pageTitle = $film['title'];
require_once 'includes/header.php';
require_once 'includes/navbar.php';

// Reload CSS with absolute path
echo '<link rel="stylesheet" href="' . SITE_URL . '/assets/css/style.css">';
echo '<link rel="stylesheet" href="' . SITE_URL . '/assets/css/responsive.css">';

// Parse Trailer
$yt_url = $film['trailer_url'] ?? '';
$yt_id = "";
if (preg_match('/(embed\/|v=)([^&?]+)/', $yt_url, $matches)) {
    $yt_id = $matches[2];
}
$posterUrl = strpos($film['poster'], 'http') === 0 ? $film['poster'] : 'assets/uploads/posters/' . $film['poster'];
$bannerUrl = strpos($film['banner'], 'http') === 0 ? $film['banner'] : 'assets/uploads/films/' . $film['banner'];
if (empty($film['banner'])) {
    $bannerUrl = "https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=1920"; // Default cinematic backdrop
}
?>

<style>
    body { background-color: #080a0e; color: #f0f0f0; }
    .film-hero {
        position: relative;
        height: 70vh;
        min-height: 500px;
        background-size: cover;
        background-position: center top;
        background-attachment: fixed;
    }
    .film-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(8, 10, 14, 0.3) 0%, rgba(8, 10, 14, 1) 100%);
    }
    .hero-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding-bottom: 3rem;
        z-index: 2;
    }
    .film-poster {
        width: 100%;
        max-width: 300px;
        border-radius: 10px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.8);
        border: 1px solid rgba(255,255,255,0.1);
        margin-top: -150px;
        position: relative;
        z-index: 3;
    }
    .text-gold { color: #d4af37; }
    .bg-dark-glass {
        background: rgba(20, 24, 30, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.05);
    }
    .stat-divider { width: 1px; height: 40px; background: rgba(255,255,255,0.1); }
    .album-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }
    .album-img:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,0.5);
    }
    .trailer-container {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.1);
    }
</style>

<!-- Hero Backdrop -->
<div class="film-hero" style="background-image: url('<?php echo htmlspecialchars($bannerUrl); ?>');">
    <div class="hero-content container">
        <div class="row">
            <div class="col-lg-3 d-none d-lg-block"></div> <!-- Spacer for poster -->
            <div class="col-lg-9 text-center text-lg-start">
                <h1 class="display-3 fw-bold text-white mb-2" style="font-family: 'Cinzel', serif; letter-spacing: 2px;">
                    <?php echo htmlspecialchars($film['title']); ?>
                </h1>
                
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start align-items-center gap-3 mb-3 text-uppercase small fw-bold" style="letter-spacing: 1px; color: #a0a5b0;">
                    <span><?php echo $film['year']; ?></span>
                    <?php if (!empty($film['age_rating'])): ?>
                        <span>•</span>
                        <span class="border border-secondary px-2 rounded"><?php echo $film['age_rating']; ?></span>
                    <?php endif; ?>
                    <span>•</span>
                    <span><?php echo $film['duration']; ?></span>
                    <?php if (!empty($film['genre'])): ?>
                        <span>•</span>
                        <span class="text-gold"><?php echo $film['genre']; ?></span>
                    <?php endif; ?>
                </div>

                <?php if (!empty($film['tagline'])): ?>
                    <p class="fs-5 fst-italic mb-0" style="color: #ccc;">"<?php echo htmlspecialchars($film['tagline']); ?>"</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Area -->
<div class="container pb-5">
    <div class="row g-5">
        
        <!-- Left Sidebar (Poster & Quick Stats) -->
        <div class="col-lg-3 text-center text-lg-start">
            <img src="<?php echo htmlspecialchars($posterUrl); ?>" class="film-poster mb-4 d-none d-lg-block" alt="Poster">
            
            <div class="bg-dark-glass p-4 rounded-4 mb-4 text-center">
                <div class="d-flex justify-content-around align-items-center mb-3">
                    <div>
                        <div class="text-gold h3 mb-0 fw-bold"><i class="fas fa-star me-1"></i><?php echo $film['rating_score'] ?: '-'; ?></div>
                        <div class="small text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">IMDb Rating</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div>
                        <div class="text-white h3 mb-0 fw-bold"><i class="fas fa-fire text-danger me-1"></i><?php echo $film['popularity_score'] ?: '-'; ?></div>
                        <div class="small text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Popularity</div>
                    </div>
                </div>
                <button class="btn btn-outline-light w-100 rounded-pill text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.8rem;">
                    <i class="fas fa-plus me-2"></i> Add to Watchlist
                </button>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted fw-bold border-bottom border-secondary pb-2 mb-3" style="letter-spacing: 2px; font-size: 0.8rem;">Info</h6>
                <div class="mb-2"><strong class="text-white">Director:</strong> <span class="text-gold"><?php echo htmlspecialchars($film['director']); ?></span></div>
                <?php if($film['writers']): ?><div class="mb-2"><strong class="text-white">Writers:</strong> <span style="color:#aaa;"><?php echo htmlspecialchars($film['writers']); ?></span></div><?php endif; ?>
                <?php if($film['country']): ?><div class="mb-2"><strong class="text-white">Country:</strong> <span style="color:#aaa;"><?php echo htmlspecialchars($film['country']); ?></span></div><?php endif; ?>
                <?php if($film['language']): ?><div class="mb-2"><strong class="text-white">Language:</strong> <span style="color:#aaa;"><?php echo htmlspecialchars($film['language']); ?></span></div><?php endif; ?>
            </div>
        </div>

        <!-- Right Content (Trailer, Synopsis, Album) -->
        <div class="col-lg-9 pt-lg-4">
            
            <!-- Trailer Section -->
            <?php if ($yt_id): ?>
                <div class="trailer-container mb-5 ratio ratio-21x9 bg-black">
                    <iframe src="https://www.youtube.com/embed/<?php echo $yt_id; ?>?autoplay=0&rel=0&modestbranding=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            <?php elseif (!empty($yt_url)): ?>
                <!-- Direct Video link fallback -->
                <div class="trailer-container mb-5 ratio ratio-21x9 bg-black">
                    <video controls class="w-100 h-100 object-fit-cover">
                        <source src="<?php echo htmlspecialchars($yt_url); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            <?php endif; ?>

            <!-- Synopsis -->
            <h4 class="text-uppercase fw-bold text-white mb-3" style="letter-spacing: 2px;">Synopsis</h4>
            <p class="fs-5 mb-5" style="color: #b0b5c0; line-height: 1.8;">
                <?php echo nl2br(htmlspecialchars($film['synopsis'])); ?>
            </p>

            <?php if (!empty($film['cast'])): ?>
                <h4 class="text-uppercase fw-bold text-white mb-3" style="letter-spacing: 2px;">Cast</h4>
                <p class="fs-6 mb-5" style="color: #b0b5c0;">
                    <?php echo htmlspecialchars($film['cast']); ?>
                </p>
            <?php endif; ?>

            <!-- Photo Album Section -->
            <?php if (!empty($album_photos)): ?>
                <h4 class="text-uppercase fw-bold text-white mb-4 mt-5" style="letter-spacing: 2px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px;">
                    <i class="fas fa-images text-gold me-2"></i> Photo Gallery
                </h4>
                <div class="row g-3 mb-5">
                    <?php foreach ($album_photos as $photo): ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="<?php echo htmlspecialchars($photo); ?>" target="_blank">
                                <img src="<?php echo htmlspecialchars($photo); ?>" class="album-img" alt="Film Scene">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>