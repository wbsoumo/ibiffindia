<?php 
$pageTitle = "Official Selection - Films";
require_once 'includes/header.php'; 
require_once 'includes/navbar.php'; 
require_once 'includes/db.php';

// Get current year or default
$selectedYear = isset($_GET['year']) ? intval($_GET['year']) : 2024;
$years = range(2024, 2017);

// Fetch Films from DB
$films = [];
if ($db) {
    $stmt = $db->prepare("SELECT * FROM films WHERE year = ? ORDER BY created_at DESC");
    $stmt->execute([$selectedYear]);
    $films = $stmt->fetchAll();
}
?>

<!-- Page Header -->
<section class="py-5 bg-black text-white mt-5">
    <div class="container py-5 text-center" data-aos="fade-up">
        <h1 class="display-4 fw-900 mb-3 text-uppercase"><?php echo htmlspecialchars(getSetting('films_page_title', 'OFFICIAL SELECTION')); ?></h1>
        <p class="lead opacity-75 mb-0" style="letter-spacing: 2px;"><?php echo htmlspecialchars(getSetting('films_page_subtitle', 'Discover the visionary cinematic works from across the globe.')); ?></p>
    </div>
</section>

<section class="section-padding py-large bg-white text-black">
    <div class="container">
        <!-- Year Filter -->
        <div class="year-filter d-flex justify-content-center flex-wrap gap-2 mb-5" data-aos="fade-up">
            <?php foreach($years as $year): ?>
                <a href="films.php?year=<?php echo $year; ?>" 
                   class="btn <?php echo ($selectedYear == $year) ? 'btn-red' : 'btn-outline-dark'; ?> px-4">
                    <?php echo $year; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="row g-4 mt-4">
            <?php if (empty($films)): ?>
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-light rounded-4">
                        <i class="fas fa-film fa-3x text-muted mb-4"></i>
                        <h4 class="text-muted">No films found for <?php echo $selectedYear; ?></h4>
                        <p class="text-muted">The selection for the current year is still in progress. Stay tuned!</p>
                        <a href="films.php?year=2023" class="btn btn-outline-red mt-3">View 2023 Selection</a>
                    </div>
                </div>
            <?php else: foreach($films as $film): ?>
            <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up">
                <a href="film/<?php echo $film['slug']; ?>" class="text-decoration-none">
                    <div class="film-card mb-3 shadow-sm" style="border-radius: 4px; overflow: hidden;">
                        <img src="<?php echo strpos($film['poster'], 'http') === 0 ? $film['poster'] : 'assets/uploads/posters/'.$film['poster']; ?>" 
                             onerror="this.src='https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800'" 
                             alt="<?php echo $film['title']; ?>" class="img-fluid w-100">
                        <div class="film-overlay">
                            <span class="badge bg-red text-white mb-2"><?php echo $film['genre']; ?></span>
                        </div>
                    </div>
                    <div class="film-meta px-1">
                        <h6 class="text-black mb-1 fw-900 text-uppercase" style="letter-spacing: 0.5px;"><?php echo $film['title']; ?></h6>
                        <p class="text-muted small mb-0 fw-bold">DIR: <?php echo $film['director']; ?></p>
                    </div>
                </a>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>

<style>
.btn-outline-red {
    border: 2px solid var(--primary-red);
    color: var(--primary-red);
    font-weight: 700;
}
.btn-outline-red:hover {
    background: var(--primary-red);
    color: #fff;
}
</style>

<?php require_once 'includes/footer.php'; ?>
