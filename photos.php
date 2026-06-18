<?php 
$pageTitle = "Gallery - Photos";
require_once 'includes/header.php'; 
require_once 'includes/navbar.php'; 
require_once 'includes/db.php';

$selectedYear = isset($_GET['year']) ? intval($_GET['year']) : 2024;
$years = range(2024, 2017);

// Fetch Images from DB
$gallery = [];
if ($db) {
    $stmt = $db->prepare("SELECT * FROM gallery WHERE year = ? ORDER BY uploaded_at DESC");
    $stmt->execute([$selectedYear]);
    $gallery = $stmt->fetchAll();
}

// Sample images if DB is empty
$sampleImages = [
    ['title' => 'Award Ceremony', 'image' => 'https://images.unsplash.com/photo-1514525253361-bee8718a300a?q=80&w=800'],
    ['title' => 'Red Carpet Moments', 'image' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=800'],
    ['title' => 'Director Talk', 'image' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=800'],
    ['title' => 'Panel Discussion', 'image' => 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=800'],
    ['title' => 'Film Screening', 'image' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=800'],
    ['title' => 'Closing Ceremony', 'image' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?q=80&w=800'],
];

if (empty($gallery)) {
    $gallery = $sampleImages;
    $isSample = true;
} else {
    $isSample = false;
}
?>

<!-- Cinematic Page Header -->
<section class="hero-section" style="background-image: url('assets/images/gallery-header-bg.png'); min-height: 50vh;">
    <div class="hero-bg-overlay"></div>
    <div class="container hero-content text-center">
        <h1 class="hero-title" style="font-size: 5rem;">
            <?php 
            $galTitle = getSetting('gallery_page_title', 'FESTIVAL GALLERY');
            $parts = explode(' ', $galTitle);
            if (count($parts) > 1) {
                $last = array_pop($parts);
                echo htmlspecialchars(implode(' ', $parts)) . ' <span class="red">' . htmlspecialchars($last) . '</span>';
            } else {
                echo htmlspecialchars($galTitle);
            }
            ?>
        </h1>
        <p class="lead text-white fw-bold" style="letter-spacing: 5px;"><?php echo htmlspecialchars(getSetting('gallery_page_subtitle', 'MOMENTS THAT DEFINE CINEMA')); ?></p>
    </div>
</section>

<section class="section-padding py-large bg-white text-black">
    <div class="container">
        <!-- Year Filter -->
        <div class="year-filter d-flex justify-content-center flex-wrap gap-2 mb-5" data-aos="fade-up">
            <?php foreach($years as $year): ?>
                <a href="photos.php?year=<?php echo $year; ?>" 
                   class="btn <?php echo ($selectedYear == $year) ? 'btn-red' : 'btn-outline-dark'; ?> px-4 fw-bold">
                    <?php echo $year; ?> EDITION
                </a>
            <?php endforeach; ?>
        </div>

        <div class="row g-4 mt-4">
            <?php foreach($gallery as $img): ?>
            <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up">
                <div class="gallery-card-modern">
                    <a href="<?php echo (strpos($img['image'], 'http') === 0 || $isSample) ? $img['image'] : 'assets/uploads/gallery/'.$img['image']; ?>" class="glightbox">
                        <div class="gallery-img-wrapper shadow-sm">
                            <img src="<?php echo (strpos($img['image'], 'http') === 0 || $isSample) ? $img['image'] : 'assets/uploads/gallery/'.$img['image']; ?>" 
                                 onerror="this.src='https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=800'" 
                                 alt="<?php echo $img['title']; ?>" class="img-fluid w-100">
                            <div class="gallery-overlay">
                                <i class="fas fa-expand-alt text-white fa-2x"></i>
                            </div>
                        </div>
                    </a>
                    <div class="mt-3 text-center">
                        <h6 class="text-black mb-1 fw-900 text-uppercase small" style="letter-spacing: 1px;"><?php echo $img['title']; ?></h6>
                        <p class="text-muted small mb-0 fw-bold"><?php echo $selectedYear; ?> EDITION</p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if ($isSample): ?>
        <div class="text-center mt-5 py-4 bg-light rounded-2" data-aos="fade-up">
            <p class="text-muted mb-0 fw-bold small text-uppercase" style="letter-spacing: 2px;">
                <i class="fas fa-camera me-2 red"></i> Currently showing archive highlights for <?php echo $selectedYear; ?>
            </p>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
.gallery-card-modern {
    transition: var(--transition);
}
.gallery-img-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 4px;
    aspect-ratio: 4 / 3;
}
.gallery-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}
.gallery-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(198, 2, 2, 0.4);
    display: flex; align-items: center; justify-content: center;
    opacity: 0;
    transition: var(--transition);
}
.gallery-card-modern:hover .gallery-img-wrapper img {
    transform: scale(1.1);
}
.gallery-card-modern:hover .gallery-overlay {
    opacity: 1;
}
</style>

<!-- GLightbox -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script>
    const lightbox = GLightbox({
        touchNavigation: true,
        loop: true,
        autoplayVideos: true
    });
</script>

<?php require_once 'includes/footer.php'; ?>
