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

$pageTitle = $film['title'];
require_once 'includes/header.php';
require_once 'includes/navbar.php';

// Reload CSS with absolute path to fix /film/slug URL rewriting issue
echo '<link rel="stylesheet" href="' . SITE_URL . '/assets/css/style.css">';
echo '<link rel="stylesheet" href="' . SITE_URL . '/assets/css/responsive.css">';

// Parse Trailer
$yt_url = $film['trailer_url'] ?? '';
$yt_id = "";
if (preg_match('/(embed\/|v=)([^&?]+)/', $yt_url, $matches)) {
    $yt_id = $matches[2];
}
?>

<div class="bg-black text-white pb-5" style="min-height: 100vh; padding-top: 120px;">
    <!-- Title Header -->
    <div class="container mb-4" data-aos="fade-in">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end">
            <div>
                <h1 class="display-4 fw-bold mb-1" style="font-family: 'Barlow', sans-serif;">
                    <?php echo $film['title']; ?></h1>
                <ul class="list-inline text-muted small fw-bold text-uppercase mb-0" style="letter-spacing: 1px;">
                    <li class="list-inline-item"><?php echo $film['year']; ?></li>
                    <li class="list-inline-item">•</li>
                    <?php if (!empty($film['age_rating'])): ?>
                        <li class="list-inline-item"><?php echo $film['age_rating']; ?></li>
                        <li class="list-inline-item">•</li>
                    <?php endif; ?>
                    <li class="list-inline-item"><?php echo $film['duration']; ?></li>
                    <li class="list-inline-item">•</li>
                    <li class="list-inline-item text-white border border-secondary px-2 rounded-1">
                        <?php echo $film['genre']; ?></li>
                </ul>
            </div>
            <div class="mt-3 mt-md-0 text-md-end">
                <div class="d-flex align-items-center gap-4">
                    <div class="text-center d-none d-md-block">
                        <div class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">IMDb Rating
                        </div>
                        <div class="h5 mb-0 fw-bold text-white"><i class="fas fa-star text-warning me-1"></i>
                            <?php echo $film['rating_score'] ?: 'N/A'; ?> <span
                                class="text-muted fs-6 fw-normal">/10</span></div>
                        <small class="text-muted"
                            style="font-size: 0.75rem;"><?php echo $film['rating_count'] ?: '—'; ?></small>
                    </div>
                    <div class="vr bg-secondary opacity-25 d-none d-md-block" style="height:50px;"></div>
                    <div class="text-center d-none d-md-block">
                        <div class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">Your Rating
                        </div>
                        <div class="h5 mb-0 fw-bold" style="color:#4da6ff; cursor:pointer;"><i
                                class="far fa-star me-1"></i> Rate</div>
                        <small class="text-muted" style="font-size: 0.75rem;">Add yours</small>
                    </div>
                    <div class="vr bg-secondary opacity-25 d-none d-md-block" style="height:50px;"></div>
                    <div class="text-center d-none d-md-block">
                        <div class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">Popularity
                        </div>
                        <div class="h5 mb-0 fw-bold text-white"><i class="fas fa-arrow-trend-up text-success me-1"></i>
                            <?php echo $film['popularity_score'] ?: 'N/A'; ?></div>
                        <small class="text-muted" style="font-size: 0.75rem;">rank</small>
                    </div>
                    <div class="vr bg-secondary opacity-25 d-none d-md-block" style="height:50px;"></div>
                    <div class="text-center">
                        <div class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">IBIFF Status
                        </div>
                        <div class="h5 mb-0 fw-bold" style="color:var(--gold);"><i class="fas fa-award me-1"></i>
                            <?php echo $film['festival_status'] ?: 'Selected'; ?></div>
                        <small class="text-muted" style="font-size: 0.75rem;">Official</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Media Section (IMDb Style: Trailer + Poster) -->
    <div class="container mb-5" data-aos="fade-up">
        <div class="row g-1 bg-dark-custom p-2 rounded-3 shadow-lg">
            <div class="col-lg-3 d-none d-lg-block">
                <img src="<?php echo strpos($film['poster'], 'http') === 0 ? $film['poster'] : 'assets/uploads/posters/' . $film['poster']; ?>"
                    onerror="this.src='https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800'"
                    class="img-fluid rounded-start w-100 h-100 object-fit-cover"
                    alt="<?php echo $film['title']; ?> Poster">
            </div>
            <div class="col-lg-7">
                <div class="ratio ratio-16x9 h-100 overflow-hidden bg-black position-relative">
                    <?php if ($yt_id): ?>
                        <iframe src="https://www.youtube.com/embed/<?php echo $yt_id; ?>?autoplay=0&rel=0"
                            title="YouTube video" allowfullscreen></iframe>
                    <?php else: ?>
                        <!-- Fallback to Banner if no trailer -->
                        <img src="<?php echo strpos($film['banner'], 'http') === 0 ? $film['banner'] : 'assets/uploads/films/' . $film['banner']; ?>"
                            onerror="this.src='https://images.unsplash.com/photo-1440404653325-ab127d49abc1?q=80&w=1200'"
                            class="w-100 h-100 object-fit-cover opacity-50" alt="Banner">
                        <div class="position-absolute top-50 start-50 translate-middle text-center">
                            <i class="fas fa-film fa-3x text-muted mb-2"></i>
                            <p class="text-muted text-uppercase fw-bold letter-spacing-1 mb-0">Trailer Not Available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-2 d-none d-lg-flex flex-column gap-1">
                <div class="flex-grow-1 bg-dark d-flex flex-column align-items-center justify-content-center rounded-top-end position-relative text-white cursor-pointer hover-overlay"
                    style="min-height: 120px;">
                    <i class="fas fa-play-circle fa-2x mb-2 text-muted"></i>
                    <span class="small fw-bold letter-spacing-1">1 VIDEO</span>
                </div>
                <div class="flex-grow-1 bg-dark d-flex flex-column align-items-center justify-content-center rounded-bottom-end position-relative text-white cursor-pointer hover-overlay"
                    style="min-height: 120px;">
                    <i class="fas fa-image fa-2x mb-2 text-muted"></i>
                    <span class="small fw-bold letter-spacing-1">PHOTOS</span>
                </div>
            </div>
        </div>
        <!-- Mobile Poster (Hidden on Desktop) -->
        <div class="d-lg-none mt-3 row g-3">
            <div class="col-4">
                <img src="<?php echo strpos($film['poster'], 'http') === 0 ? $film['poster'] : 'assets/uploads/posters/' . $film['poster']; ?>"
                    class="img-fluid rounded shadow" alt="Poster">
            </div>
            <div class="col-8 d-flex flex-column justify-content-center">
                <h5 class="fw-bold"><?php echo $film['title']; ?></h5>
                <span class="badge bg-danger align-self-start mb-2"><?php echo $film['genre']; ?></span>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container">
        <div class="row g-5">
            <!-- Left Column: Details -->
            <div class="col-lg-8" data-aos="fade-right">

                <?php if (!empty($film['genre'])): ?>
                    <div class="mb-3 d-flex flex-wrap gap-2">
                        <?php
                        $genres = explode(',', $film['genre']);
                        foreach ($genres as $g):
                            ?>
                            <span
                                class="badge rounded-pill border border-secondary text-white fw-normal px-3 py-2 bg-transparent"><?php echo trim($g); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($film['tagline'])): ?>
                    <h5 class="fw-bold text-white mb-4 fst-italic" style="letter-spacing: 1px;">
                        "<?php echo $film['tagline']; ?>"</h5>
                <?php endif; ?>

                <div class="mb-4">
                    <p class="fs-5 text-light opacity-75" style="line-height: 1.8;">
                        <?php echo nl2br($film['synopsis']); ?></p>
                </div>

                <hr class="border-secondary opacity-25 my-4">

                <div class="crew-list">
                    <div class="row align-items-start mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                        <div class="col-md-3 fw-bold text-white">Director</div>
                        <div class="col-md-9 text-primary-light fw-bold">
                            <a href="director-profile.php?name=<?php echo urlencode($film['director']); ?>"
                                class="text-primary-light text-decoration-none border-bottom border-primary border-opacity-50 pb-1 hover-opacity">
                                <?php echo $film['director']; ?>
                            </a>
                        </div>
                    </div>
                    <?php if (!empty($film['writers'])): ?>
                        <div class="row align-items-start mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                            <div class="col-md-3 fw-bold text-white">Writers</div>
                            <div class="col-md-9 text-primary-light"><?php echo $film['writers']; ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if ($film['producer']): ?>
                        <div class="row align-items-start mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                            <div class="col-md-3 fw-bold text-white">Producer</div>
                            <div class="col-md-9 text-primary-light"><?php echo $film['producer']; ?></div>
                        </div>
                    <?php endif; ?>
                    <div class="row align-items-start mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                        <div class="col-md-3 fw-bold text-white">Stars</div>
                        <div class="col-md-9 text-primary-light"><?php echo $film['cast']; ?></div>
                    </div>
                </div>

                <?php if ($film['awards']): ?>
                    <div class="mt-5 bg-dark-custom p-4 rounded-3 border-start border-4 border-gold">
                        <h5 class="text-gold fw-bold mb-3 text-uppercase" style="letter-spacing: 1px;"><i
                                class="fas fa-trophy me-2"></i> Awards & Recognition</h5>
                        <p class="mb-0 text-light opacity-75"><?php echo $film['awards']; ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Sidebar Info -->
            <div class="col-lg-4" data-aos="fade-left">
                <div class="bg-dark-custom p-4 rounded-3 border border-secondary border-opacity-25 mb-4">
                    <h5 class="fw-bold text-uppercase mb-4 border-bottom border-secondary border-opacity-25 pb-3">
                        Details</h5>

                    <div class="mb-3">
                        <span class="d-block text-muted small text-uppercase fw-bold">Country of Origin</span>
                        <span class="text-white"><?php echo $film['country']; ?></span>
                    </div>
                    <div class="mb-3">
                        <span class="d-block text-muted small text-uppercase fw-bold">Language</span>
                        <span class="text-white"><?php echo $film['language']; ?></span>
                    </div>
                    <div class="mb-3">
                        <span class="d-block text-muted small text-uppercase fw-bold">Runtime</span>
                        <span class="text-white"><?php echo $film['duration']; ?></span>
                    </div>
                    <div class="mb-0">
                        <span class="d-block text-muted small text-uppercase fw-bold">Official Selection</span>
                        <span class="text-gold fw-bold">IBIFF India <?php echo $film['year']; ?></span>
                    </div>
                </div>

                <!-- Add to Watchlist / Share (Mock functionality) -->
                <button class="btn btn-outline-light w-100 py-3 mb-3 fw-bold"
                    onclick="alert('Added to your festival schedule!')">
                    <i class="fas fa-plus me-2"></i> Add to Schedule
                </button>
                <div class="d-flex gap-2">
                    <button class="btn btn-dark border border-secondary w-100"
                        onclick="window.open('https://twitter.com/intent/tweet?text=Check out <?php echo urlencode($film['title']); ?> at IBIFF India!', '_blank')"><i
                            class="fab fa-twitter"></i> Share</button>
                    <button class="btn btn-dark border border-secondary w-100"
                        onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied!');"><i
                            class="fas fa-link"></i> Copy</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-dark-custom {
        background-color: #1a1a1a;
    }

    .text-primary-light {
        color: #4da6ff;
    }

    .text-gold {
        color: #c9a84c;
    }

    .border-gold {
        border-color: #c9a84c !important;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .letter-spacing-1 {
        letter-spacing: 1px;
    }

    .crew-list .row:last-child {
        border-bottom: none !important;
        padding-bottom: 0 !important;
        margin-bottom: 0 !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .hover-overlay {
        transition: background-color 0.2s ease;
    }

    .hover-overlay:hover {
        background-color: #2a2a2a !important;
    }

    .hover-opacity {
        transition: opacity 0.2s;
    }

    .hover-opacity:hover {
        opacity: 0.7;
    }

    .film-rating-bar .vr {
        width: 1px;
    }
</style>

<?php require_once 'includes/footer.php'; ?>