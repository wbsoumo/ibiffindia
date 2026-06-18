<?php 
$pageTitle = "IBIFF INDIA | Indo-Bangla International Film Festival";
require_once 'includes/header.php'; 
require_once 'includes/navbar.php'; 
require_once 'includes/db.php';

// Fetch all dynamic settings
$s = [];
if ($db) {
    try {
        $stmt = $db->query("SELECT setting_key, setting_value FROM site_settings");
        $s = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    } catch (PDOException $e) {
        // Fallback array if table doesn't exist yet
        $s = [];
    }
}

// Accessor helper
function getSetting($key, $default = '') {
    global $s;
    return isset($s[$key]) ? $s[$key] : $default;
}

// Fetch Featured Films (Last 4)
$featuredFilms = [];
if ($db) {
    $stmt = $db->query("SELECT * FROM films ORDER BY created_at DESC LIMIT 4");
    $featuredFilms = $stmt->fetchAll();
}
?>

<!-- Cinematic Hero Section -->
<section class="hero-section" style="background-image: url('<?php echo htmlspecialchars(getSetting('hero_bg_image', 'assets/images/hero-bg.png')); ?>');">
    <div class="hero-bg-overlay"></div>
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-12 text-center" data-aos="fade-up">
                <span class="section-tag mb-4" data-aos="fade-down" data-aos-delay="200">
                    <?php echo htmlspecialchars(getSetting('hero_edition_tag', 'Official 2025 Edition')); ?>
                </span>
                
                <?php 
                $rawTitle = getSetting('hero_title', 'IBIFF INDIA');
                // Highlight the last word if it's "INDIA" or "FESTIVAL" in red
                $titleParts = explode(' ', $rawTitle);
                if (count($titleParts) > 1) {
                    $lastWord = array_pop($titleParts);
                    $firstPart = implode(' ', $titleParts);
                    $styledTitle = htmlspecialchars($firstPart) . ' <span class="red">' . htmlspecialchars($lastWord) . '</span>';
                } else {
                    $styledTitle = htmlspecialchars($rawTitle);
                }
                ?>
                <h1 class="hero-title" style="font-family: 'Cinzel', serif; font-weight: 900;">
                    <?php echo $styledTitle; ?>
                </h1>
                
                <p class="lead mb-5 text-light fw-bold hero-subtitle">
                    <?php echo htmlspecialchars(getSetting('hero_subtitle', 'Celebrating Cinematic Excellence Across Borders')); ?>
                </p>
                
                <div class="hero-btns mt-5">
                    <?php if (getSetting('hero_cta_text_1')): ?>
                        <a href="<?php echo htmlspecialchars(getSetting('hero_cta_url_1', 'films.php')); ?>" class="btn btn-premium btn-red me-3">
                            <?php echo htmlspecialchars(getSetting('hero_cta_text_1')); ?>
                        </a>
                    <?php endif; ?>
                    <?php if (getSetting('hero_cta_text_2')): ?>
                        <a href="<?php echo htmlspecialchars(getSetting('hero_cta_url_2', 'https://filmfreeway.com')); ?>" target="_blank" class="btn btn-premium btn-outline-white">
                            <?php echo htmlspecialchars(getSetting('hero_cta_text_2')); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Scroll Down Indicator -->
    <div class="scroll-down">
        <span class="red">SCROLL</span>
        <div class="line"></div>
    </div>
</section>

<!-- Welcome & Edition Section -->
<section class="welcome-section py-large bg-white text-dark">
    <div class="container">
        <div class="row align-items-stretch">
            <div class="col-lg-7 pe-lg-5" data-aos="fade-right">
                <p class="text-danger fw-bold mb-2">
                    <?php echo htmlspecialchars(getSetting('welcome_tag', 'Welcome to')); ?>
                </p>
                
                <?php 
                $welcomeTitle = getSetting('welcome_title', 'THE INTERNATIONAL INDO-BANGLA FILM FESTIVAL IBIFF INDIA');
                // Render with styling logic (split by space or newlines if any)
                $styledWelcomeTitle = nl2br(htmlspecialchars($welcomeTitle));
                ?>
                <h2 class="welcome-title-large mb-4 text-dark font-cinzel">
                    <?php echo $styledWelcomeTitle; ?>
                </h2>
                
                <ul class="list-unstyled welcome-list mb-5">
                    <?php for ($i = 1; $i <= 4; $i++): 
                        $bullet = getSetting("welcome_bullet_$i");
                        if (!empty($bullet)):
                    ?>
                        <li><?php echo htmlspecialchars($bullet); ?></li>
                    <?php endif; endfor; ?>
                </ul>
                
                <div class="content-box mb-5 border-start border-danger border-4 ps-4 py-2 bg-light">
                    <h5 class="fw-bold mb-3 text-dark">
                        <?php echo htmlspecialchars(getSetting('welcome_subheading', '8th International Indo-Bangla Film Festival (IBIFF) 2025!')); ?>
                    </h5>
                    <p class="text-muted mb-0">
                        <?php echo nl2br(htmlspecialchars(getSetting('welcome_text'))); ?>
                    </p>
                </div>
                <a href="about.php" class="btn btn-premium btn-red">DISCOVER MORE</a>
            </div>
            
            <div class="col-lg-5 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="welcome-poster-section shadow-lg d-flex flex-column justify-content-between h-100">
                    <h3 class="text-dark fw-bold border-bottom pb-3 mb-4 text-center">
                        <?php echo htmlspecialchars(getSetting('welcome_poster_title', 'IBIFF 2026 EDITION')); ?>
                    </h3>
                    <div class="poster-container overflow-hidden mb-4 rounded shadow-sm">
                        <img src="<?php echo htmlspecialchars(getSetting('welcome_poster_image', 'assets/images/poster1.jpg')); ?>" alt="Welcome Poster" class="img-fluid w-100 hover-zoom">
                    </div>
                    <div class="stats-mini row g-0 text-center border-top pt-4">
                        <div class="col-6 border-end">
                            <h4 class="fw-900 mb-0 text-danger"><?php echo htmlspecialchars(getSetting('welcome_stat_1_val', '50+')); ?></h4>
                            <p class="small text-muted mb-0"><?php echo htmlspecialchars(getSetting('welcome_stat_1_lbl', 'Categories')); ?></p>
                        </div>
                        <div class="col-6">
                            <h4 class="fw-900 mb-0 text-dark"><?php echo htmlspecialchars(getSetting('welcome_stat_2_val', '200+')); ?></h4>
                            <p class="small text-muted mb-0"><?php echo htmlspecialchars(getSetting('welcome_stat_2_lbl', 'Selections')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- NEW IKSFF-Inspired Dynamic Festival Highlights Overview -->
<section class="highlights-overview-section py-large bg-black text-white position-relative">
    <div class="container position-relative z-index-2">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-tag">FESTIVAL AT A GLANCE</span>
            <h2 class="section-heading text-white">HYBRID CELEBRATION <span class="red">HIGHLIGHTS</span></h2>
            <p class="text-muted max-w-700 mx-auto">Explore key schedules, screening locations, digital streaming access, and competitive genres of the film festival.</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Box 1: Dates -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="highlight-card h-100 d-flex flex-column justify-content-between p-4">
                    <div class="card-top">
                        <div class="card-icon bg-red bg-opacity-10 rounded-circle mb-4">
                            <i class="fas fa-calendar-alt red"></i>
                        </div>
                        <h4 class="card-title fw-bold text-white mb-3">
                            <?php echo htmlspecialchars(getSetting('highlights_dates_title', 'Festival Dates')); ?>
                        </h4>
                        <p class="card-desc text-muted mb-0">
                            <?php echo htmlspecialchars(getSetting('highlights_dates_subtitle', 'This hybrid festival will be held from:')); ?>
                        </p>
                    </div>
                    <div class="card-bottom mt-4">
                        <div class="date-highlight text-gold fw-bold py-2 px-3 border border-secondary border-opacity-25 rounded bg-dark bg-opacity-50">
                            <?php echo htmlspecialchars(getSetting('highlights_dates_range', '18th to 24th January, 2026')); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 2: Physical Venues -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="highlight-card h-100 d-flex flex-column justify-content-between p-4">
                    <div class="card-top">
                        <div class="card-icon bg-red bg-opacity-10 rounded-circle mb-4">
                            <i class="fas fa-map-marker-alt red"></i>
                        </div>
                        <h4 class="card-title fw-bold text-white mb-3">
                            <?php echo htmlspecialchars(getSetting('highlights_venue_title', 'Physical Venues')); ?>
                        </h4>
                        <ul class="list-unstyled venue-list mb-0">
                            <?php if (getSetting('highlights_venue_1')): ?>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fas fa-chevron-right red mt-1 small"></i>
                                    <span class="small text-muted"><?php echo htmlspecialchars(getSetting('highlights_venue_1')); ?></span>
                                </li>
                            <?php endif; ?>
                            <?php if (getSetting('highlights_venue_2')): ?>
                                <li class="d-flex align-items-start gap-2">
                                    <i class="fas fa-chevron-right red mt-1 small"></i>
                                    <span class="small text-muted"><?php echo htmlspecialchars(getSetting('highlights_venue_2')); ?></span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Box 3: Online Festival -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="highlight-card h-100 d-flex flex-column justify-content-between p-4">
                    <div class="card-top">
                        <div class="card-icon bg-red bg-opacity-10 rounded-circle mb-4">
                            <i class="fas fa-tv red"></i>
                        </div>
                        <h4 class="card-title fw-bold text-white mb-3">
                            <?php echo htmlspecialchars(getSetting('highlights_online_title', 'Online Festival')); ?>
                        </h4>
                        <p class="card-desc text-muted mb-3">
                            <?php echo htmlspecialchars(getSetting('highlights_online_subtitle', 'Streaming on')); ?>
                        </p>
                        <?php if (getSetting('highlights_online_logo')): ?>
                            <div class="logo-wrapper py-2 text-center bg-dark bg-opacity-20 rounded border border-secondary border-opacity-10 mb-3">
                                <img src="<?php echo htmlspecialchars(getSetting('highlights_online_logo')); ?>" alt="Online Partner" class="img-fluid" style="max-height: 40px; object-fit: contain;">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-bottom mt-auto">
                        <?php if (getSetting('highlights_online_url')): ?>
                            <a href="<?php echo htmlspecialchars(getSetting('highlights_online_url')); ?>" target="_blank" class="btn btn-outline-white btn-sm w-100 py-2 border-secondary">
                                VISIT STREAM ZONE <i class="fas fa-external-link-alt ms-1 small"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Box 4: Categories -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <div class="highlight-card h-100 d-flex flex-column justify-content-between p-4">
                    <div class="card-top">
                        <div class="card-icon bg-red bg-opacity-10 rounded-circle mb-4">
                            <i class="fas fa-photo-film red"></i>
                        </div>
                        <h4 class="card-title fw-bold text-white mb-3">
                            <?php echo htmlspecialchars(getSetting('highlights_categories_title', 'Festival Categories')); ?>
                        </h4>
                        <div class="categories-tags d-flex flex-wrap gap-2">
                            <?php 
                            $cats = getSetting('highlights_categories_list', 'Short Film, Documentary, Music Video');
                            $catArray = explode(',', $cats);
                            foreach ($catArray as $cat):
                                $catClean = trim($cat);
                                if (!empty($catClean)):
                            ?>
                                <span class="badge bg-secondary bg-opacity-20 text-light border border-secondary border-opacity-25 px-3 py-2">
                                    <?php echo htmlspecialchars($catClean); ?>
                                </span>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Overlapping Mission Section -->
<section class="py-large bg-light overlap-container">
    <div class="container">
        <div class="row g-0 align-items-center">
            <div class="col-lg-6 overlap-image" data-aos="fade-right">
                <img src="<?php echo htmlspecialchars(getSetting('mission_image', 'assets/images/poster.jpg')); ?>" alt="IBIFF Mission" class="img-fluid shadow-lg">
            </div>
            <div class="col-lg-7 overlap-content text-dark" data-aos="fade-left">
                <span class="section-tag text-muted"><?php echo htmlspecialchars(getSetting('mission_tag', 'Our Vision')); ?></span>
                <h2 class="section-heading text-dark font-cinzel">
                    <?php 
                    $missionTitle = getSetting('mission_title', 'BRIDGING CULTURES THROUGH CINEMA');
                    $titleParts = explode(' ', $missionTitle);
                    if (count($titleParts) > 1) {
                        $lastWord = array_pop($titleParts);
                        $firstPart = implode(' ', $titleParts);
                        echo htmlspecialchars($firstPart) . ' <span class="red">' . htmlspecialchars($lastWord) . '</span>';
                    } else {
                        echo htmlspecialchars($missionTitle);
                    }
                    ?>
                </h2>
                <p class="lead text-dark mb-4 fw-semibold">
                    <?php echo htmlspecialchars(getSetting('mission_subtitle')); ?>
                </p>
                <p class="text-muted mb-5">
                    <?php echo nl2br(htmlspecialchars(getSetting('mission_text'))); ?>
                </p>
                <div class="d-flex gap-4">
                    <div class="feature-item d-flex align-items-center gap-2">
                        <i class="fas fa-trophy fa-lg red"></i>
                        <span class="fw-bold text-dark text-uppercase small" style="letter-spacing: 1px;">Global Reach</span>
                    </div>
                    <div class="feature-item d-flex align-items-center gap-2">
                        <i class="fas fa-link fa-lg red"></i>
                        <span class="fw-bold text-dark text-uppercase small" style="letter-spacing: 1px;">Creative Synergy</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News & Highlights Marquee -->
<section class="bg-black py-5 overflow-hidden border-top border-bottom border-secondary border-opacity-10">
    <div class="container-fluid px-0">
        <div class="text-center mb-4" data-aos="fade-up">
            <span class="section-tag text-muted">In The Spotlight</span>
            <h3 class="text-white fw-900 text-uppercase" style="letter-spacing: 2px;">MOMENTS & <span class="red">MEMORIES</span></h3>
        </div>
        <div class="news-marquee-container mt-4">
            <div class="news-marquee-content">
                <?php 
                $newsImages = glob('newsimages/*.{jpg,jpeg,png}', GLOB_BRACE);
                if (!empty($newsImages)) {
                    // Output two tracks for infinite scrolling
                    for ($i = 0; $i < 2; $i++) {
                        echo '<div class="news-marquee-track">';
                        foreach ($newsImages as $img) {
                            echo '<img src="' . htmlspecialchars($img) . '" class="news-image rounded shadow" alt="Festival Moment">';
                        }
                        echo '</div>';
                    }
                } else {
                    // Fallback placeholder images if folder is empty
                    for ($i = 0; $i < 2; $i++) {
                        echo '<div class="news-marquee-track">';
                        for ($j = 1; $j <= 6; $j++) {
                            echo '<img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=400" class="news-image rounded shadow" alt="Festival Moment">';
                        }
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Why IBIFF Section -->
<section class="py-large bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <span class="section-tag text-muted">
                    <?php echo htmlspecialchars(getSetting('why_tag', 'Why Join Us?')); ?>
                </span>
                <h2 class="section-heading text-dark">
                    <?php 
                    $whyTitle = getSetting('why_title', 'A PLATFORM FOR VISIONARIES');
                    $titleParts = explode(' ', $whyTitle);
                    if (count($titleParts) > 1) {
                        $lastWord = array_pop($titleParts);
                        $firstPart = implode(' ', $titleParts);
                        echo htmlspecialchars($firstPart) . ' <span class="red">' . htmlspecialchars($lastWord) . '</span>';
                    } else {
                        echo htmlspecialchars($whyTitle);
                    }
                    ?>
                </h2>
                <p class="lead text-dark mb-5">
                    <?php echo htmlspecialchars(getSetting('why_subtitle')); ?>
                </p>
                
                <div class="row g-4">
                    <?php for ($i = 1; $i <= 4; $i++): 
                        $title = getSetting("why_item_{$i}_title");
                        $desc = getSetting("why_item_{$i}_desc");
                        if (!empty($title)):
                            // Icon picker based on item index
                            $icons = ['fa-globe-asia', 'fa-handshake', 'fa-graduation-cap', 'fa-star'];
                            $icon = $icons[$i - 1];
                    ?>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-circle bg-light p-3 rounded-circle" style="width: 55px; height: 55px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas <?php echo $icon; ?> red fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($title); ?></h6>
                                    <p class="small text-muted mb-0"><?php echo htmlspecialchars($desc); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; endfor; ?>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="row g-3 mesh-mimic">
                    <div class="col-6 mesh-item">
                        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=400" alt="Festival" class="img-fluid shadow rounded hover-zoom">
                    </div>
                    <div class="col-6 mesh-item pt-5">
                        <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=400" alt="Festival" class="img-fluid shadow rounded hover-zoom">
                    </div>
                    <div class="col-12 mesh-item">
                        <img src="https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=600" alt="Festival" class="img-fluid shadow rounded hover-zoom">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Film Grid -->
<section class="py-large bg-black">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-tag">Selection Highlights</span>
            <h2 class="section-heading text-white">FESTIVAL <span class="red">HIGHLIGHTS</span></h2>
            <p class="text-muted max-w-700 mx-auto">Explore some of the critically acclaimed selections and masterpieces screened in our official editions.</p>
        </div>
        
        <div class="row g-0">
            <?php if (empty($featuredFilms)): ?>
                <!-- Fallback to cinematic placeholders if DB empty -->
                <div class="col-md-3">
                    <div class="film-card-premium">
                        <img src="https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800" alt="Film">
                        <div class="film-card-info">
                            <span class="badge bg-red mb-2">Drama</span>
                            <h4>The Last Frame</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="film-card-premium">
                        <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=800" alt="Film">
                        <div class="film-card-info">
                            <span class="badge bg-red mb-2">Documentary</span>
                            <h4>Urban Pulse</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="film-card-premium">
                        <img src="https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=800" alt="Film">
                        <div class="film-card-info">
                            <span class="badge bg-red mb-2">Short Film</span>
                            <h4>Silent Echoes</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="film-card-premium">
                        <img src="https://images.unsplash.com/photo-1514525253361-bee8718a300a?q=80&w=800" alt="Film">
                        <div class="film-card-info">
                            <span class="badge bg-red mb-2">Music Video</span>
                            <h4>Neon Rhythms</h4>
                        </div>
                    </div>
                </div>
            <?php else: foreach($featuredFilms as $film): ?>
            <div class="col-md-3" data-aos="zoom-in">
                <a href="film-details.php?slug=<?php echo htmlspecialchars($film['slug']); ?>">
                    <div class="film-card-premium">
                        <img src="<?php echo strpos($film['poster'], 'http') === 0 ? $film['poster'] : 'assets/uploads/posters/'.$film['poster']; ?>" 
                             onerror="this.src='https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800'" alt="<?php echo htmlspecialchars($film['title']); ?>">
                        <div class="film-card-info">
                            <span class="badge bg-red mb-2"><?php echo htmlspecialchars($film['genre']); ?></span>
                            <h4><?php echo htmlspecialchars($film['title']); ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; endif; ?>
        </div>
        <div class="text-center mt-5">
            <a href="films.php" class="btn btn-outline-white btn-premium">VIEW FULL SELECTION</a>
        </div>
    </div>
</section>

<!-- CineBridge Impact -->
<section class="cinebridge-section" style="background-image: url('<?php echo htmlspecialchars(getSetting('cinebridge_bg_image', 'assets/images/cinebridge-bg.png')); ?>');">
    <div class="cinebridge-overlay"></div>
    <div class="container position-relative z-index-2 text-center text-white" data-aos="zoom-in">
        <span class="section-tag text-white">
            <?php echo htmlspecialchars(getSetting('cinebridge_tag', 'Film Marketplace')); ?>
        </span>
        <h2 class="display-3 fw-900 mb-4" style="font-family: 'Cinzel', serif;">
            <?php 
            $cbTitle = getSetting('cinebridge_title', 'CINEBRIDGE INDIA');
            $titleParts = explode(' ', $cbTitle);
            if (count($titleParts) > 1) {
                $lastWord = array_pop($titleParts);
                $firstPart = implode(' ', $titleParts);
                echo htmlspecialchars($firstPart) . ' <span class="red">' . htmlspecialchars($lastWord) . '</span>';
            } else {
                echo htmlspecialchars($cbTitle);
            }
            ?>
        </h2>
        <p class="lead mb-5 max-w-700 mx-auto opacity-75">
            <?php echo htmlspecialchars(getSetting('cinebridge_subtitle')); ?>
        </p>
        <div class="d-flex justify-content-center gap-3">
            <?php if (getSetting('cinebridge_cta_text_1')): ?>
                <a href="<?php echo htmlspecialchars(getSetting('cinebridge_cta_url_1', 'about.php#cinebridge')); ?>" class="btn btn-premium btn-red">
                    <?php echo htmlspecialchars(getSetting('cinebridge_cta_text_1')); ?>
                </a>
            <?php endif; ?>
            <?php if (getSetting('cinebridge_cta_text_2')): ?>
                <a href="<?php echo htmlspecialchars(getSetting('cinebridge_cta_url_2', 'contact.php')); ?>" class="btn btn-premium btn-outline-white">
                    <?php echo htmlspecialchars(getSetting('cinebridge_cta_text_2')); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="text-center py-5 bg-white overflow-hidden border-top">
    <div class="container">
        <h6 class="text-uppercase text-muted small fw-bold mb-5" style="letter-spacing: 5px;">Our Proud Partners</h6>
    </div>
    <div class="marquee-container">
        <div class="marquee-content">
            <div class="marquee-track">
                <img src="https://static.wixstatic.com/media/494556_b37a3b3f46f44d8583796d8e06f9d3b4~mv2.png" alt="Partner" class="partner-logo">
                <img src="https://static.wixstatic.com/media/494556_8f3d6c1f1b6a4b1b8b8f3b8b8f3b8b8f~mv2.png" alt="Partner" class="partner-logo">
                <img src="https://static.wixstatic.com/media/494556_7b8b8f3b8b8f3b8b8f3b8b8f3b8b8f3b~mv2.png" alt="Partner" class="partner-logo">
                <img src="https://static.wixstatic.com/media/494556_3b8b8f3b8b8f3b8b8f3b8b8f3b8b8f3b~mv2.png" alt="Partner" class="partner-logo">
            </div>
            <!-- Duplicate content for smooth infinite scrolling -->
            <div class="marquee-track">
                <img src="https://static.wixstatic.com/media/494556_b37a3b3f46f44d8583796d8e06f9d3b4~mv2.png" alt="Partner" class="partner-logo">
                <img src="https://static.wixstatic.com/media/494556_8f3d6c1f1b6a4b1b8b8f3b8b8f3b8b8f~mv2.png" alt="Partner" class="partner-logo">
                <img src="https://static.wixstatic.com/media/494556_7b8b8f3b8b8f3b8b8f3b8b8f3b8b8f3b~mv2.png" alt="Partner" class="partner-logo">
                <img src="https://static.wixstatic.com/media/494556_3b8b8f3b8b8f3b8b8f3b8b8f3b8b8f3b~mv2.png" alt="Partner" class="partner-logo">
            </div>
        </div>
    </div>
</section>

<style>
.scroll-down {
    position: absolute;
    bottom: 50px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 5;
    text-align: center;
}
.scroll-down span {
    display: block;
    font-size: 0.7rem;
    font-weight: 900;
    letter-spacing: 5px;
    margin-bottom: 10px;
    animation: fadePulse 2s infinite;
}
.scroll-down .line {
    width: 2px;
    height: 60px;
    background: var(--primary-red);
    margin: 0 auto;
    animation: lineExtend 2s infinite;
}

@keyframes fadePulse {
    0%, 100% { opacity: 0.3; }
    50% { opacity: 1; }
}
@keyframes lineExtend {
    0% { height: 0; transform-origin: top; }
    50% { height: 60px; transform-origin: top; }
    50.1% { height: 60px; transform-origin: bottom; }
    100% { height: 0; transform-origin: bottom; }
}

.feature-item h6 {
    letter-spacing: 1px;
    margin-top: 10px;
}
.max-w-700 { max-width: 700px; }

/* Marquee Styles */
.marquee-container {
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
    position: relative;
    padding: 20px 0;
}
.marquee-content {
    display: flex;
    width: max-content;
    animation: scrollMarquee 20s linear infinite;
}
.marquee-track {
    display: flex;
    align-items: center;
    gap: 100px;
    padding-right: 100px;
}
.partner-logo {
    height: 80px;
    opacity: 0.6;
    transition: 0.3s ease;
}
.partner-logo:hover {
    opacity: 1;
}
@keyframes scrollMarquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

/* News Marquee Styles */
.news-marquee-container {
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
    position: relative;
    padding: 10px 0;
}
.news-marquee-container:hover .news-marquee-content {
    animation-play-state: paused;
}
.news-marquee-content {
    display: flex;
    width: max-content;
    animation: scrollNewsMarquee 25s linear infinite;
}
.news-marquee-track {
    display: flex;
    align-items: center;
    gap: 30px;
    padding-right: 30px;
}
.news-image {
    height: 300px;
    width: auto;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
    cursor: pointer;
}
.news-image:hover {
    transform: scale(1.05);
    z-index: 10;
    position: relative;
    border-color: var(--primary-red);
    box-shadow: 0 10px 20px rgba(0,0,0,0.5) !important;
}
@keyframes scrollNewsMarquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.font-cinzel {
    font-family: 'Cinzel', serif;
}
.hover-zoom {
    transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.hover-zoom:hover {
    transform: scale(1.08);
}
</style>

<?php require_once 'includes/footer.php'; ?>
