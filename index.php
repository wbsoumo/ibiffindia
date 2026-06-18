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

<!-- Main Landing Section (Two-Column Precision Replica) -->
<section class="landing-section">
    <div class="container">
        <div class="row align-items-stretch">
            <!-- Left Column: Content -->
            <div class="col-lg-7 pe-lg-5" data-aos="fade-right">
                <h1 class="welcome-title-large text-uppercase font-cinzel">
                    <span class="text-red">THE INTERNATIONAL</span><br>
                    <span class="text-navy">INDO-BANGLA FILM FESTIVAL</span><br>
                    <span class="text-red">IBIFF INDIA</span>
                </h1>
                
                <div class="separator-line"></div>
                
                <h5 class="text-red fw-bold mb-4">
                    <?php echo htmlspecialchars(getSetting('welcome_subheading', '8th International Indo-Bangla Film Festival (IBIFF) 2026!')); ?>
                </h5>
                
                <div class="welcome-desc-block mb-4">
                    <p class="text-muted">
                        <?php echo nl2br(htmlspecialchars(getSetting('welcome_text'))); ?>
                    </p>
                </div>
                
                <!-- Separator line -->
                <div class="separator-line" style="width: 100%; height: 1px; background-color: var(--border-color); margin: 30px 0;"></div>
                
                <!-- Festival Committee Info -->
                <div class="committee-info mb-4">
                    <h5 class="fw-bold text-navy mb-3">Festival Management</h5>
                    <p class="mb-2 text-dark">
                        <span class="fw-bold text-navy">Festival Chairman:</span> 
                        <span class="text-red font-barlow fw-semibold">Sourav Chakraborty</span>
                    </p>
                    <p class="mb-2 text-dark">
                        <span class="fw-bold text-navy">Festival Director:</span> 
                        <span class="text-red font-barlow fw-semibold">Raju Biswas</span>
                    </p>
                    <p class="mb-2 text-dark">
                        <span class="fw-bold text-navy">Chief Advisor:</span> 
                        <span class="text-red font-barlow fw-semibold">Dr. Amit Chaudhuri</span>
                    </p>
                </div>

                <div class="separator-line" style="width: 100%; height: 1px; background-color: var(--border-color); margin: 30px 0;"></div>

                <!-- Why Submit list -->
                <h5 class="fw-bold text-navy mb-3">Why be a part of IBIFF 2026?</h5>
                <ul class="list-unstyled welcome-list mb-5">
                    <?php for ($i = 1; $i <= 4; $i++): 
                        $bullet = getSetting("welcome_bullet_$i");
                        if (!empty($bullet)):
                    ?>
                        <li><?php echo htmlspecialchars($bullet); ?></li>
                    <?php endif; endfor; ?>
                </ul>
                
                <div class="cta-actions">
                    <a href="<?php echo htmlspecialchars(getSetting('hero_cta_url_2', 'https://filmfreeway.com')); ?>" target="_blank" class="btn btn-premium btn-red px-5 py-3 fw-bold">
                        <i class="fab fa-wpforms me-2"></i> SUBMIT YOUR FILM
                    </a>
                </div>
            </div>
            
            <!-- Right Column: Poster Card -->
            <div class="col-lg-5 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="welcome-poster-section d-flex flex-column justify-content-between h-100">
                    <h3 class="text-navy fw-bold border-bottom pb-3 mb-4 text-center">
                        <?php echo htmlspecialchars(getSetting('welcome_poster_title', 'IBIFF 2026 EDITION')); ?>
                    </h3>
                    <div class="poster-container overflow-hidden mb-4 rounded shadow-sm bg-light text-center p-2 border">
                        <img src="<?php echo htmlspecialchars(getSetting('welcome_poster_image', 'assets/images/poster1.jpg')); ?>" alt="IBIFF Edition Poster" class="img-fluid w-100 rounded">
                    </div>
                    <div class="stats-mini row g-0 text-center border-top pt-4">
                        <div class="col-6 border-end">
                            <h4 class="fw-900 mb-0 text-red"><?php echo htmlspecialchars(getSetting('welcome_stat_1_val', '50+')); ?></h4>
                            <p class="small text-muted mb-0"><?php echo htmlspecialchars(getSetting('welcome_stat_1_lbl', 'Categories')); ?></p>
                        </div>
                        <div class="col-6">
                            <h4 class="fw-900 mb-0 text-navy"><?php echo htmlspecialchars(getSetting('welcome_stat_2_val', '200+')); ?></h4>
                            <p class="small text-muted mb-0"><?php echo htmlspecialchars(getSetting('welcome_stat_2_lbl', 'Selections')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Highlights Overview Section (4 Cards - same to same like IKSFF) -->
<section class="highlights-overview-section py-large">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-heading text-navy text-uppercase">
                INTERNATIONAL INDO-BANGLA FILM FESTIVAL 2026
            </h2>
            <div class="separator-line centered"></div>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Box 1: Dates -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="highlight-card h-100 d-flex flex-column justify-content-between p-4 bg-white">
                    <div class="card-top">
                        <div class="card-icon rounded-circle mb-4">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">
                            <?php echo htmlspecialchars(getSetting('highlights_dates_title', 'Festival Dates')); ?>
                        </h4>
                        <p class="card-desc text-muted mb-0">
                            <?php echo htmlspecialchars(getSetting('highlights_dates_subtitle', 'This hybrid festival will be held from:')); ?>
                        </p>
                    </div>
                    <div class="card-bottom mt-4">
                        <div class="date-highlight py-2 px-3 rounded">
                            <?php echo htmlspecialchars(getSetting('highlights_dates_range', '18th to 24th January, 2026')); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 2: Physical Venues -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="highlight-card h-100 d-flex flex-column justify-content-between p-4 bg-white">
                    <div class="card-top">
                        <div class="card-icon rounded-circle mb-4">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">
                            <?php echo htmlspecialchars(getSetting('highlights_venue_title', 'Physical Venues')); ?>
                        </h4>
                        <ul class="list-unstyled venue-list mb-0">
                            <?php if (getSetting('highlights_venue_1')): ?>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fas fa-chevron-right text-red mt-1 small"></i>
                                    <span class="small"><?php echo htmlspecialchars(getSetting('highlights_venue_1')); ?></span>
                                </li>
                            <?php endif; ?>
                            <?php if (getSetting('highlights_venue_2')): ?>
                                <li class="d-flex align-items-start gap-2">
                                    <i class="fas fa-chevron-right text-red mt-1 small"></i>
                                    <span class="small"><?php echo htmlspecialchars(getSetting('highlights_venue_2')); ?></span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Box 3: Online Festival -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="highlight-card h-100 d-flex flex-column justify-content-between p-4 bg-white">
                    <div class="card-top">
                        <div class="card-icon rounded-circle mb-4">
                            <i class="fas fa-tv"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">
                            <?php echo htmlspecialchars(getSetting('highlights_online_title', 'Online Festival')); ?>
                        </h4>
                        <p class="card-desc text-muted mb-3">
                            <?php echo htmlspecialchars(getSetting('highlights_online_subtitle', 'Streaming on')); ?>
                        </p>
                        <?php if (getSetting('highlights_online_logo')): ?>
                            <div class="logo-wrapper py-2 text-center bg-light rounded border mb-3">
                                <img src="<?php echo htmlspecialchars(getSetting('highlights_online_logo')); ?>" alt="Online Partner" class="img-fluid" style="max-height: 40px; object-fit: contain;">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-bottom mt-auto">
                        <?php if (getSetting('highlights_online_url')): ?>
                            <a href="<?php echo htmlspecialchars(getSetting('highlights_online_url')); ?>" target="_blank" class="btn btn-outline-navy btn-sm w-100 py-2">
                                VISIT STREAM ZONE <i class="fas fa-external-link-alt ms-1 small"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Box 4: Categories -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <div class="highlight-card h-100 d-flex flex-column justify-content-between p-4 bg-white">
                    <div class="card-top">
                        <div class="card-icon rounded-circle mb-4">
                            <i class="fas fa-photo-film"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">
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
                                <span class="badge px-3 py-2">
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

<!-- Special Initiative Section (replica from IKSFF) -->
<section class="special-initiative-section py-large">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="zoom-in">
                <div class="initiative-box">
                    <div class="text-center mb-4">
                        <span class="initiative-tag text-uppercase">A Special Initiative By</span>
                        <h2 class="initiative-title text-uppercase mt-2">Indo-Bangla International Film Festival</h2>
                        <div class="separator-line centered" style="background-color: #316142;"></div>
                    </div>
                    
                    <div class="text-center my-4 py-3">
                        <h4 class="initiative-topic text-uppercase mb-2">WORLD ENVIRONMENT DAY 2026</h4>
                        <h1 class="display-5 fw-bold text-dark font-cinzel">Whispers Of Tomorrow</h1>
                        <p class="lead text-muted mt-3">A dedicated screening program highlighting Nature, Climate Change & Our Global Future.</p>
                    </div>
                    
                    <div class="initiative-details text-center">
                        <div class="row g-3">
                            <div class="col-md-4 border-end border-opacity-10 border-success">
                                <p class="mb-0 text-muted small uppercase fw-bold">TIME</p>
                                <h5 class="fw-bold mb-0">5:00 PM onwards</h5>
                            </div>
                            <div class="col-md-4 border-end border-opacity-10 border-success">
                                <p class="mb-0 text-muted small uppercase fw-bold">DATE</p>
                                <h5 class="fw-bold mb-0">4TH JUNE, 2026</h5>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-0 text-muted small uppercase fw-bold">VENUE</p>
                                <h5 class="fw-bold mb-0">PRESS CLUB, KOLKATA</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Overlapping Mission Section (Light Theme) -->
<section class="py-large overlap-container">
    <div class="container">
        <div class="row g-0 align-items-center">
            <div class="col-lg-6 overlap-image" data-aos="fade-right">
                <img src="<?php echo htmlspecialchars(getSetting('mission_image', 'assets/images/poster.jpg')); ?>" alt="IBIFF Mission" class="img-fluid rounded">
            </div>
            <div class="col-lg-7 overlap-content text-dark" data-aos="fade-left">
                <span class="section-tag text-muted"><?php echo htmlspecialchars(getSetting('mission_tag', 'Our Vision')); ?></span>
                <h2 class="section-heading text-navy font-cinzel">
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
                <div class="separator-line"></div>
                <p class="lead text-navy mb-4 fw-semibold">
                    <?php echo htmlspecialchars(getSetting('mission_subtitle')); ?>
                </p>
                <p class="text-muted mb-4">
                    <?php echo nl2br(htmlspecialchars(getSetting('mission_text'))); ?>
                </p>
                <div class="d-flex gap-4">
                    <div class="feature-item d-flex align-items-center gap-2">
                        <i class="fas fa-trophy text-red"></i>
                        <span class="fw-bold text-navy text-uppercase small" style="letter-spacing: 1px;">Global Reach</span>
                    </div>
                    <div class="feature-item d-flex align-items-center gap-2">
                        <i class="fas fa-link text-red"></i>
                        <span class="fw-bold text-navy text-uppercase small" style="letter-spacing: 1px;">Creative Synergy</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why IBIFF Section (Light Theme) -->
<section class="py-large bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <span class="section-tag text-muted">
                    <?php echo htmlspecialchars(getSetting('why_tag', 'Why Join Us?')); ?>
                </span>
                <h2 class="section-heading text-navy">
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
                <div class="separator-line"></div>
                <p class="lead text-muted mb-5">
                    <?php echo htmlspecialchars(getSetting('why_subtitle')); ?>
                </p>
                
                <div class="row g-4">
                    <?php for ($i = 1; $i <= 4; $i++): 
                        $title = getSetting("why_item_{$i}_title");
                        $desc = getSetting("why_item_{$i}_desc");
                        if (!empty($title)):
                            $icons = ['fa-globe-asia', 'fa-handshake', 'fa-graduation-cap', 'fa-star'];
                            $icon = $icons[$i - 1];
                    ?>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-circle p-3 rounded-circle" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas <?php echo $icon; ?> text-red"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-navy mb-1"><?php echo htmlspecialchars($title); ?></h6>
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
                        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=400" alt="Festival" class="img-fluid rounded">
                    </div>
                    <div class="col-6 mesh-item pt-5">
                        <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=400" alt="Festival" class="img-fluid rounded">
                    </div>
                    <div class="col-12 mesh-item">
                        <img src="https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=600" alt="Festival" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Laurels & Award Highlights Grid -->
<section class="py-large bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-tag">OFFICIAL HONORS</span>
            <h2 class="section-heading text-navy">AWARD SELECTIONS & <span class="red">WINNERS</span></h2>
            <div class="separator-line centered"></div>
            
            <!-- Laurels Graphic Emblem -->
            <div class="laurels-emblem py-3">
                <img src="https://static.wixstatic.com/media/494556_5657154e08d94af48e968ec8625994f2~mv2.png" alt="Laurels emblem" class="laurels-header-icon">
            </div>
        </div>
        
        <div class="row g-4">
            <?php if (empty($featuredFilms)): ?>
                <!-- Fallback to placeholders if DB empty -->
                <div class="col-md-3">
                    <div class="film-card-premium rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800" alt="Film">
                        <div class="film-card-info">
                            <span class="badge bg-red mb-2">Drama</span>
                            <h4>The Last Frame</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="film-card-premium rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=800" alt="Film">
                        <div class="film-card-info">
                            <span class="badge bg-red mb-2">Documentary</span>
                            <h4>Urban Pulse</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="film-card-premium rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=800" alt="Film">
                        <div class="film-card-info">
                            <span class="badge bg-red mb-2">Short Film</span>
                            <h4>Silent Echoes</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="film-card-premium rounded shadow-sm">
                        <img src="https://images.unsplash.com/photo-1514525253361-bee8718a300a?q=80&w=800" alt="Film">
                        <div class="film-card-info">
                            <span class="badge bg-red mb-2">Music Video</span>
                            <h4>Neon Rhythms</h4>
                        </div>
                    </div>
                </div>
            <?php else: foreach($featuredFilms as $film): ?>
            <div class="col-md-6 col-lg-3" data-aos="zoom-in">
                <a href="film-details.php?slug=<?php echo htmlspecialchars($film['slug']); ?>">
                    <div class="film-card-premium rounded shadow-sm">
                        <img src="<?php echo strpos($film['poster'], 'http') === 0 ? $film['poster'] : 'assets/uploads/posters/'.$film['poster']; ?>" 
                             onerror="this.src='https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800'" alt="<?php echo htmlspecialchars($film['title']); ?>">
                        <div class="film-card-info">
                            <span class="badge bg-danger mb-2"><?php echo htmlspecialchars($film['genre']); ?></span>
                            <h4><?php echo htmlspecialchars($film['title']); ?></h4>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; endif; ?>
        </div>
        <div class="text-center mt-5">
            <a href="films.php" class="btn btn-outline-navy btn-premium px-5 py-3 fw-bold">VIEW FULL SELECTION</a>
        </div>
    </div>
</section>

<!-- CineBridge Impact Section (Light overlay on Scroll) -->
<section class="cinebridge-section" style="background-image: url('<?php echo htmlspecialchars(getSetting('cinebridge_bg_image', 'assets/images/cinebridge-bg.png')); ?>');">
    <div class="cinebridge-overlay"></div>
    <div class="container position-relative z-index-2 text-center text-white" data-aos="zoom-in">
        <span class="section-tag text-white">
            <?php echo htmlspecialchars(getSetting('cinebridge_tag', 'Film Marketplace')); ?>
        </span>
        <h2 class="display-4 fw-900 mb-4 text-white" style="font-family: 'Cinzel', serif;">
            CINEBRIDGE <span class="text-red">INDIA</span>
        </h2>
        <p class="lead mb-5 max-w-700 mx-auto opacity-90">
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

<!-- Moments & Memories (Gallery Scroll) -->
<section class="bg-white py-5 overflow-hidden border-top">
    <div class="container-fluid px-0">
        <div class="text-center mb-4" data-aos="fade-up">
            <span class="section-tag text-muted">In The Spotlight</span>
            <h3 class="text-navy fw-900 text-uppercase font-cinzel">MOMENTS & <span class="red">MEMORIES</span></h3>
        </div>
        <div class="news-marquee-container mt-4">
            <div class="news-marquee-content">
                <?php 
                $newsImages = glob('newsimages/*.{jpg,jpeg,png}', GLOB_BRACE);
                if (!empty($newsImages)) {
                    for ($i = 0; $i < 2; $i++) {
                        echo '<div class="news-marquee-track">';
                        foreach ($newsImages as $img) {
                            echo '<img src="' . htmlspecialchars($img) . '" class="news-image rounded shadow-sm" alt="Festival Moment">';
                        }
                        echo '</div>';
                    }
                } else {
                    for ($i = 0; $i < 2; $i++) {
                        echo '<div class="news-marquee-track">';
                        for ($j = 1; $j <= 6; $j++) {
                            echo '<img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=400" class="news-image rounded shadow-sm" alt="Festival Moment">';
                        }
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Partners Section (Scrolling Logos) -->
<section class="text-center py-5 bg-light overflow-hidden border-top border-bottom">
    <div class="container">
        <h6 class="text-uppercase text-muted small fw-bold mb-5" style="letter-spacing: 5px;">Our Proud Partners</h6>
    </div>
    <div class="marquee-container bg-light">
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
/* Marquee Scrolling Rules */
.marquee-container {
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
    position: relative;
    padding: 10px 0;
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
@keyframes scrollMarquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

/* News Marquee Scrolling Rules */
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
    height: 280px;
    width: auto;
    object-fit: cover;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    cursor: pointer;
}
.news-image:hover {
    transform: scale(1.03);
    border-color: var(--primary-red);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}
@keyframes scrollNewsMarquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

.max-w-700 { max-width: 700px; }
.font-cinzel { font-family: 'Cinzel', serif; }
.font-barlow { font-family: 'Barlow', sans-serif; }
</style>

<?php require_once 'includes/footer.php'; ?>
