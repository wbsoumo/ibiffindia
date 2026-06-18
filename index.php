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

<!-- Top Image Slider Section -->
<section class="top-image-slider">
    <div class="swiper topHeroSlider">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <img src="https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=1920" alt="Film Production Scene 1" class="img-fluid w-100 hero-slider-img">
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide">
                <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=1920" alt="Film Production Scene 2" class="img-fluid w-100 hero-slider-img">
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <img src="https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=1920" alt="Film Production Scene 3" class="img-fluid w-100 hero-slider-img">
            </div>
        </div>
        <!-- Pagination & Navigation -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next text-red"></div>
        <div class="swiper-button-prev text-red"></div>
    </div>
</section>

<!-- Top Welcome Banner Section -->
<section class="top-welcome-banner text-center">
    <div class="container" data-aos="fade-down">
        <h1 class="top-welcome-title font-cinzel text-uppercase">
            Welcome to <span class="red">THE INTERNATIONAL</span> INDO-BANGLA FILM FESTIVAL <span class="red">| IBIFF INDIA</span>
        </h1>
        <div class="separator-line centered"></div>
    </div>
</section>

<!-- Main Landing Section -->
<section class="landing-section">
    <div class="container">
        <div class="row align-items-stretch">
            <!-- Left Column: Content -->
            <div class="col-lg-7 pe-lg-5" data-aos="fade-right">
                <h2 class="welcome-title-large text-uppercase font-cinzel text-gradient-navy">
                    CELEBRATING CROSS-BORDER CINEMA
                </h2>
                
                <div class="separator-line"></div>
                
                <h5 class="text-red fw-bold mb-4 font-barlow" style="letter-spacing: 1.5px; font-size: 1.1rem;">
                    <?php echo htmlspecialchars(getSetting('welcome_subheading', '8th International Indo-Bangla Film Festival (IBIFF) 2026!')); ?>
                </h5>
                
                <div class="welcome-desc-block mb-4">
                    <p class="text-muted" style="font-size: 1.05rem; line-height: 1.8;">
                        <?php echo nl2br(htmlspecialchars(getSetting('welcome_text'))); ?>
                    </p>
                </div>
                
                <!-- Separator line -->
                <div class="separator-line" style="width: 100%; height: 1px; background-color: var(--border-color); margin: 30px 0;"></div>
                
                <!-- Festival Committee Info -->
                <div class="committee-info mb-4 bg-light p-4 border rounded shadow-sm position-relative overflow-hidden">
                    <div style="position: absolute; right: -20px; bottom: -20px; font-size: 8rem; color: rgba(3,27,51,0.02); pointer-events: none; font-family: 'Cinzel', serif;">IBIFF</div>
                    <h5 class="fw-bold text-navy mb-3 border-bottom pb-2 font-cinzel" style="font-size: 1.15rem; letter-spacing: 0.5px;">FESTIVAL MANAGEMENT</h5>
                    <p class="mb-2 text-dark d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-user-tie me-2 text-red"></i> <strong class="text-navy">Festival Chairman:</strong></span> 
                        <span class="text-red font-barlow fw-bold" style="font-size: 1.05rem;">Sourav Chakraborty</span>
                    </p>
                    <p class="mb-2 text-dark d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-user me-2 text-red"></i> <strong class="text-navy">Festival Director:</strong></span> 
                        <span class="text-red font-barlow fw-bold" style="font-size: 1.05rem;">Raju Biswas</span>
                    </p>
                    <p class="mb-2 text-dark d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-award me-2 text-red"></i> <strong class="text-navy">Chief Advisor:</strong></span> 
                        <span class="text-red font-barlow fw-bold" style="font-size: 1.05rem;">Dr. Amit Chaudhuri</span>
                    </p>
                </div>

                <div class="separator-line" style="width: 100%; height: 1px; background-color: var(--border-color); margin: 30px 0;"></div>

                <!-- Why Submit list -->
                <h5 class="fw-bold text-navy mb-3 font-cinzel text-uppercase" style="font-size: 1.1rem; letter-spacing: 0.5px;">Why submit your film?</h5>
                <ul class="list-unstyled welcome-list mb-5">
                    <?php for ($i = 1; $i <= 4; $i++): 
                        $bullet = getSetting("welcome_bullet_$i");
                        if (!empty($bullet)):
                    ?>
                        <li><?php echo htmlspecialchars($bullet); ?></li>
                    <?php endif; endfor; ?>
                </ul>
                
                <div class="cta-actions">
                    <a href="<?php echo htmlspecialchars(getSetting('hero_cta_url_2', 'https://filmfreeway.com')); ?>" target="_blank" class="btn btn-premium btn-red btn-pulse px-5 py-3 fw-bold shadow">
                        <i class="fab fa-wpforms me-2"></i> SUBMIT YOUR FILM
                    </a>
                </div>
            </div>
            
            <!-- Right Column: Poster Card -->
            <div class="col-lg-5 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="welcome-poster-section d-flex flex-column justify-content-between h-100 shadow-lg">
                    <h3 class="text-navy fw-bold border-bottom pb-3 mb-4 text-center text-uppercase font-cinzel" style="font-size: 1.35rem; letter-spacing: 1px;">
                        <?php echo htmlspecialchars(getSetting('welcome_poster_title', 'IBIFF 2026 EDITION')); ?>
                    </h3>
                    <div class="poster-container overflow-hidden mb-4 rounded shadow-sm">
                        <img src="<?php echo htmlspecialchars(getSetting('welcome_poster_image', 'assets/images/poster1.jpg')); ?>" alt="IBIFF Edition Poster" class="img-fluid w-100 rounded">
                    </div>
                    <div class="stats-mini row g-0 text-center border-top pt-4">
                        <div class="col-6 border-end">
                            <h4 class="fw-900 mb-0 text-red"><?php echo htmlspecialchars(getSetting('welcome_stat_1_val', '50+')); ?></h4>
                            <p class="small text-muted mb-0 font-barlow fw-bold"><?php echo htmlspecialchars(getSetting('welcome_stat_1_lbl', 'Categories')); ?></p>
                        </div>
                        <div class="col-6">
                            <h4 class="fw-900 mb-0 text-navy"><?php echo htmlspecialchars(getSetting('welcome_stat_2_val', '200+')); ?></h4>
                            <p class="small text-muted mb-0 font-barlow fw-bold"><?php echo htmlspecialchars(getSetting('welcome_stat_2_lbl', 'Selections')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Highlights Overview Section (4 Cards - Glowing UI) -->
<section class="highlights-overview-section py-large position-relative" style="background: #050a12; z-index: 1;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-heading text-white text-uppercase font-cinzel" style="font-size: 2.3rem; letter-spacing: 1.5px; text-shadow: 0 0 20px rgba(255,255,255,0.1);">
                FESTIVAL OVERVIEW & KEY HIGHLIGHTS
            </h2>
            <div class="separator-line centered mt-3"></div>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Box 1: Dates -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="highlight-card h-100 d-flex flex-column justify-content-between p-4">
                    <div class="card-top">
                        <div class="card-icon rounded-circle mb-4 shadow-sm">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3 font-cinzel text-white">
                            <?php echo htmlspecialchars(getSetting('highlights_dates_title', 'Festival Dates')); ?>
                        </h4>
                        <p class="card-desc text-light opacity-75 mb-0">
                            <?php echo htmlspecialchars(getSetting('highlights_dates_subtitle', 'This hybrid festival will be held from:')); ?>
                        </p>
                    </div>
                    <div class="card-bottom mt-4">
                        <div class="date-highlight py-2 px-3 rounded shadow-sm fw-bold">
                            <?php echo htmlspecialchars(getSetting('highlights_dates_range', '18th to 24th January, 2026')); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 2: Physical Venues -->
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="highlight-card h-100 d-flex flex-column justify-content-between p-4">
                    <div class="card-top">
                        <div class="card-icon rounded-circle mb-4 shadow-sm">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3 font-cinzel text-white">
                            <?php echo htmlspecialchars(getSetting('highlights_venue_title', 'Physical Venues')); ?>
                        </h4>
                        <ul class="list-unstyled venue-list mb-0">
                            <?php if (getSetting('highlights_venue_1')): ?>
                                <li class="d-flex align-items-start gap-2 mb-3">
                                    <i class="fas fa-chevron-right text-gold mt-1 small"></i>
                                    <span class="small fw-semibold text-light opacity-75"><?php echo htmlspecialchars(getSetting('highlights_venue_1')); ?></span>
                                </li>
                            <?php endif; ?>
                            <?php if (getSetting('highlights_venue_2')): ?>
                                <li class="d-flex align-items-start gap-2">
                                    <i class="fas fa-chevron-right text-gold mt-1 small"></i>
                                    <span class="small fw-semibold text-light opacity-75"><?php echo htmlspecialchars(getSetting('highlights_venue_2')); ?></span>
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
                        <div class="card-icon rounded-circle mb-4 shadow-sm">
                            <i class="fas fa-tv"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3 font-cinzel text-white">
                            <?php echo htmlspecialchars(getSetting('highlights_online_title', 'Online Festival')); ?>
                        </h4>
                        <p class="card-desc text-light opacity-75 mb-3">
                            <?php echo htmlspecialchars(getSetting('highlights_online_subtitle', 'Streaming on')); ?>
                        </p>
                        <?php if (getSetting('highlights_online_logo')): ?>
                            <div class="logo-wrapper py-2 text-center rounded border border-light border-opacity-10 mb-3 bg-white shadow-inner">
                                <img src="<?php echo htmlspecialchars(getSetting('highlights_online_logo')); ?>" alt="Online Partner" class="img-fluid" style="max-height: 40px; object-fit: contain; filter: brightness(0.9);">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-bottom mt-auto">
                        <?php if (getSetting('highlights_online_url')): ?>
                            <a href="<?php echo htmlspecialchars(getSetting('highlights_online_url')); ?>" target="_blank" class="btn btn-outline-gold btn-sm w-100 py-2 fw-bold" style="border-color: var(--gold-solid); color: var(--gold-solid);">
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
                        <div class="card-icon rounded-circle mb-4 shadow-sm">
                            <i class="fas fa-photo-film"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3 font-cinzel text-white">
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
                                <span class="badge px-3 py-2 shadow-sm fw-bold">
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
                        <h2 class="initiative-title text-uppercase mt-2 font-cinzel">Indo-Bangla International Film Festival</h2>
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
                                <p class="mb-0 text-muted small uppercase fw-bold font-barlow">TIME</p>
                                <h5 class="fw-bold mb-0">5:00 PM onwards</h5>
                            </div>
                            <div class="col-md-4 border-end border-opacity-10 border-success">
                                <p class="mb-0 text-muted small uppercase fw-bold font-barlow">DATE</p>
                                <h5 class="fw-bold mb-0">4TH JUNE, 2026</h5>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-0 text-muted small uppercase fw-bold font-barlow">VENUE</p>
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
<section class="py-5 bg-white">
    <div class="container overflow-hidden">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="position-relative">
                    <img src="<?php echo htmlspecialchars(getSetting('mission_image', 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?q=80&w=800')); ?>" alt="IBIFF Mission" class="img-fluid rounded shadow-lg w-100" style="object-fit: cover; min-height: 450px;">
                    <div class="position-absolute bottom-0 end-0 bg-white p-3 shadow-sm rounded-start mb-4 d-none d-md-block" style="transform: translateX(10%);">
                        <h4 class="font-cinzel text-navy mb-0">10+ Years</h4>
                        <p class="small text-muted mb-0">Of Cinematic Excellence</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 px-lg-5" data-aos="fade-left">
                <span class="section-tag text-muted"><?php echo htmlspecialchars(getSetting('mission_tag', 'Our Vision')); ?></span>
                <h2 class="section-heading text-navy font-cinzel mb-4">
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
                <div class="separator-line mb-4"></div>
                <p class="lead text-navy mb-3 fw-semibold">
                    <?php echo htmlspecialchars(getSetting('mission_subtitle', 'Uniting filmmakers and audiences from across the globe.')); ?>
                </p>
                <p class="text-muted mb-4">
                    <?php echo nl2br(htmlspecialchars(getSetting('mission_text', "The International Indo-Bangla Film Festival (IBIFF) is a premier platform dedicated to showcasing the finest independent cinema. Our mission is to foster cross-cultural dialogue through the universal language of film. We provide an unparalleled opportunity for visionary storytellers to present their work to an international audience, critics, and industry professionals. Join us in celebrating the magic of cinema and the powerful stories that connect us all."))); ?>
                </p>
                <div class="row g-3 mt-2">
                    <div class="col-sm-6">
                        <div class="feature-item d-flex align-items-center gap-3 p-3 border rounded shadow-sm bg-light">
                            <i class="fas fa-trophy text-red fs-4"></i>
                            <span class="fw-bold text-navy text-uppercase small">Global Reach</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-item d-flex align-items-center gap-3 p-3 border rounded shadow-sm bg-light">
                            <i class="fas fa-link text-red fs-4"></i>
                            <span class="fw-bold text-navy text-uppercase small">Creative Synergy</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-item d-flex align-items-center gap-3 p-3 border rounded shadow-sm bg-light">
                            <i class="fas fa-users text-red fs-4"></i>
                            <span class="fw-bold text-navy text-uppercase small">Diverse Voices</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-item d-flex align-items-center gap-3 p-3 border rounded shadow-sm bg-light">
                            <i class="fas fa-film text-red fs-4"></i>
                            <span class="fw-bold text-navy text-uppercase small">Industry Networking</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why IBIFF Section (Light Theme) -->
<section class="py-5 bg-light overflow-hidden">
    <div class="container">
        <div class="row align-items-center flex-column-reverse flex-lg-row g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-tag text-muted">
                    <?php echo htmlspecialchars(getSetting('why_tag', 'Why Join Us?')); ?>
                </span>
                <h2 class="section-heading text-navy font-cinzel mb-4">
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
                <div class="separator-line mb-4"></div>
                <p class="lead text-muted mb-5">
                    <?php echo htmlspecialchars(getSetting('why_subtitle', 'Elevate your filmmaking career by participating in a festival that truly values artistic merit and storytelling innovation.')); ?>
                </p>
                
                <div class="row g-4">
                    <?php 
                    $defaultWhy = [
                        ['title' => 'International Exposure', 'desc' => 'Your film will be showcased to a diverse audience and top industry executives.'],
                        ['title' => 'Valuable Networking', 'desc' => 'Connect with established directors, producers, and potential distributors.'],
                        ['title' => 'Prestigious Awards', 'desc' => 'Compete for globally recognized accolades and cash prizes.'],
                        ['title' => 'Masterclasses & Panels', 'desc' => 'Learn from the best in the business through exclusive interactive sessions.']
                    ];
                    for ($i = 1; $i <= 4; $i++): 
                        $title = getSetting("why_item_{$i}_title", $defaultWhy[$i-1]['title']);
                        $desc = getSetting("why_item_{$i}_desc", $defaultWhy[$i-1]['desc']);
                        $icons = ['fa-globe-asia', 'fa-handshake', 'fa-award', 'fa-chalkboard-teacher'];
                        $icon = $icons[$i - 1];
                    ?>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-start gap-3 bg-white p-3 rounded shadow-sm h-100 border-start border-3 border-danger transition-hover">
                                <div class="icon-circle">
                                    <i class="fas <?php echo $icon; ?> text-red fs-3 mt-1"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-navy mb-2"><?php echo htmlspecialchars($title); ?></h6>
                                    <p class="small text-muted mb-0" style="line-height: 1.6;"><?php echo htmlspecialchars($desc); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-left">
                <div class="row g-3">
                    <div class="col-6">
                        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=400" alt="Festival Action" class="img-fluid rounded shadow w-100 h-100" style="object-fit: cover; min-height: 380px;">
                    </div>
                    <div class="col-6 pt-lg-5 pt-3">
                        <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=400" alt="Networking" class="img-fluid rounded shadow w-100 mb-3" style="object-fit: cover; height: 180px;">
                        <img src="https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=600" alt="Awards" class="img-fluid rounded shadow w-100" style="object-fit: cover; height: 180px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Laurels & Award Highlights Grid (Film Tickets Overhaul) -->
<section class="py-large bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-tag">OFFICIAL HONORS</span>
            <h2 class="section-heading text-navy font-cinzel">AWARD SELECTIONS & <span class="red">WINNERS</span></h2>
            <div class="separator-line centered"></div>
            
            <!-- Laurels Graphic Emblem -->
            <div class="laurels-emblem py-3">
                <img src="https://static.wixstatic.com/media/494556_5657154e08d94af48e968ec8625994f2~mv2.png" alt="Laurels emblem" class="laurels-header-icon img-fluid">
            </div>
        </div>
        
        <div class="row g-4">
            <?php if (empty($featuredFilms)): ?>
                <!-- Fallback to placeholder film tickets if DB empty -->
                <div class="col-md-6 col-lg-3">
                    <div class="film-card-ticket">
                        <div class="ticket-image-wrapper">
                            <img src="https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800" alt="Film">
                            <div class="play-hover-btn-ticket"><i class="fas fa-play"></i></div>
                        </div>
                        <div class="ticket-info-stub text-center">
                            <div class="ticket-rating justify-content-center mb-2">
                                <i class="fas fa-star text-warning"></i> ★ 8.5/10
                            </div>
                            <h4 class="font-cinzel text-uppercase text-navy text-truncate">The Last Frame</h4>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 font-barlow mt-2">Drama</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="film-card-ticket">
                        <div class="ticket-image-wrapper">
                            <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=800" alt="Film">
                            <div class="play-hover-btn-ticket"><i class="fas fa-play"></i></div>
                        </div>
                        <div class="ticket-info-stub text-center">
                            <div class="ticket-rating justify-content-center mb-2">
                                <i class="fas fa-star text-warning"></i> ★ 8.2/10
                            </div>
                            <h4 class="font-cinzel text-uppercase text-navy text-truncate">Urban Pulse</h4>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 font-barlow mt-2">Documentary</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="film-card-ticket">
                        <div class="ticket-image-wrapper">
                            <img src="https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=800" alt="Film">
                            <div class="play-hover-btn-ticket"><i class="fas fa-play"></i></div>
                        </div>
                        <div class="ticket-info-stub text-center">
                            <div class="ticket-rating justify-content-center mb-2">
                                <i class="fas fa-star text-warning"></i> ★ 8.9/10
                            </div>
                            <h4 class="font-cinzel text-uppercase text-navy text-truncate">Silent Echoes</h4>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 font-barlow mt-2">Short Film</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="film-card-ticket">
                        <div class="ticket-image-wrapper">
                            <img src="https://images.unsplash.com/photo-1514525253361-bee8718a300a?q=80&w=800" alt="Film">
                            <div class="play-hover-btn-ticket"><i class="fas fa-play"></i></div>
                        </div>
                        <div class="ticket-info-stub text-center">
                            <div class="ticket-rating justify-content-center mb-2">
                                <i class="fas fa-star text-warning"></i> ★ 7.8/10
                            </div>
                            <h4 class="font-cinzel text-uppercase text-navy text-truncate">Neon Rhythms</h4>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 font-barlow mt-2">Music Video</span>
                        </div>
                    </div>
                </div>
            <?php else: foreach($featuredFilms as $film): ?>
            <div class="col-md-6 col-lg-3" data-aos="zoom-in">
                <a href="film-details.php?slug=<?php echo htmlspecialchars($film['slug']); ?>" class="text-decoration-none">
                    <div class="film-card-ticket">
                        <div class="ticket-image-wrapper">
                            <img src="<?php echo strpos($film['poster'], 'http') === 0 ? $film['poster'] : 'assets/uploads/posters/'.$film['poster']; ?>" 
                                 onerror="this.src='https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800'" alt="<?php echo htmlspecialchars($film['title']); ?>">
                            <div class="play-hover-btn-ticket"><i class="fas fa-play"></i></div>
                        </div>
                        <div class="ticket-info-stub text-center">
                            <div class="ticket-rating justify-content-center mb-2">
                                <i class="fas fa-star text-warning"></i> ★ <?php echo !empty($film['rating_score']) ? $film['rating_score'] : '8.2'; ?>/10
                            </div>
                            <h4 class="font-cinzel text-uppercase text-navy text-truncate"><?php echo htmlspecialchars($film['title']); ?></h4>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 font-barlow mt-2"><?php echo htmlspecialchars($film['genre']); ?></span>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; endif; ?>
        </div>
        <div class="text-center mt-5">
            <a href="films.php" class="btn btn-outline-navy btn-premium px-5 py-3 fw-bold shadow">VIEW FULL SELECTION</a>
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
        <h2 class="display-4 fw-900 mb-4 text-white" style="font-family: 'Cinzel', serif; letter-spacing: 2px;">
            CINEBRIDGE <span class="text-gradient-gold">INDIA</span>
        </h2>
        <p class="lead mb-5 max-w-700 mx-auto opacity-90" style="font-size: 1.1rem;">
            <?php echo htmlspecialchars(getSetting('cinebridge_subtitle')); ?>
        </p>
        <div class="d-flex justify-content-center gap-3">
            <?php if (getSetting('cinebridge_cta_text_1')): ?>
                <a href="<?php echo htmlspecialchars(getSetting('cinebridge_cta_url_1', 'about.php#cinebridge')); ?>" class="btn btn-premium btn-red shadow">
                    <?php echo htmlspecialchars(getSetting('cinebridge_cta_text_1')); ?>
                </a>
            <?php endif; ?>
            <?php if (getSetting('cinebridge_cta_text_2')): ?>
                <a href="<?php echo htmlspecialchars(getSetting('cinebridge_cta_url_2', 'contact.php')); ?>" class="btn btn-premium btn-outline-white shadow">
                    <?php echo htmlspecialchars(getSetting('cinebridge_cta_text_2')); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ANALOG FILM STRIP MARQUEE (Vibrant & Retro-Modern) -->
<section class="py-5 bg-white border-top border-bottom overflow-hidden">
    <div class="text-center mb-4" data-aos="fade-up">
        <span class="section-tag text-muted">In The Spotlight</span>
        <h3 class="text-navy fw-900 text-uppercase font-cinzel" style="letter-spacing: 1px;">MOMENTS & <span class="red">MEMORIES</span></h3>
    </div>
    <div class="film-strip-wrapper">
        <div class="news-marquee-container">
            <div class="news-marquee-content">
                <?php 
                $newsImages = glob('newsimages/*.{jpg,jpeg,png}', GLOB_BRACE);
                if (!empty($newsImages)) {
                    for ($i = 0; $i < 2; $i++) {
                        echo '<div class="news-marquee-track">';
                        foreach ($newsImages as $img) {
                            echo '<img src="' . htmlspecialchars($img) . '" class="news-image" alt="Festival Moment">';
                        }
                        echo '</div>';
                    }
                } else {
                    for ($i = 0; $i < 2; $i++) {
                        echo '<div class="news-marquee-track">';
                        for ($j = 1; $j <= 6; $j++) {
                            echo '<img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=400" class="news-image" alt="Festival Moment">';
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
<section class="text-center py-5 bg-light overflow-hidden border-bottom">
    <div class="container">
        <h6 class="text-uppercase text-muted small fw-bold mb-5" style="letter-spacing: 5px;">Our Proud Partners</h6>
    </div>
    <div class="marquee-container bg-light">
        <div class="marquee-content">
            <div class="marquee-track">
                <img src="https://placehold.co/200x80/f8f9fa/050a12?text=SVF+Entertainment&font=montserrat" alt="SVF" class="partner-logo" style="mix-blend-mode: multiply; filter: grayscale(100%);">
                <img src="https://placehold.co/200x80/f8f9fa/050a12?text=Hoichoi&font=montserrat" alt="Hoichoi" class="partner-logo" style="mix-blend-mode: multiply; filter: grayscale(100%);">
                <img src="https://placehold.co/200x80/f8f9fa/050a12?text=Surinder+Films&font=montserrat" alt="Surinder Films" class="partner-logo" style="mix-blend-mode: multiply; filter: grayscale(100%);">
                <img src="https://placehold.co/200x80/f8f9fa/050a12?text=Windows+Production&font=montserrat" alt="Windows Production" class="partner-logo" style="mix-blend-mode: multiply; filter: grayscale(100%);">
                <img src="https://placehold.co/200x80/f8f9fa/050a12?text=Eskay+Movies&font=montserrat" alt="Eskay Movies" class="partner-logo" style="mix-blend-mode: multiply; filter: grayscale(100%);">
                <img src="https://placehold.co/200x80/f8f9fa/050a12?text=Camellia+Films&font=montserrat" alt="Camellia Films" class="partner-logo" style="mix-blend-mode: multiply; filter: grayscale(100%);">
            </div>
            <!-- Duplicate content for smooth infinite scrolling -->
            <div class="marquee-track">
                <img src="https://placehold.co/200x80/f8f9fa/050a12?text=SVF+Entertainment&font=montserrat" alt="SVF" class="partner-logo" style="mix-blend-mode: multiply; filter: grayscale(100%);">
                <img src="https://placehold.co/200x80/f8f9fa/050a12?text=Hoichoi&font=montserrat" alt="Hoichoi" class="partner-logo" style="mix-blend-mode: multiply; filter: grayscale(100%);">
                <img src="https://placehold.co/200x80/f8f9fa/050a12?text=Surinder+Films&font=montserrat" alt="Surinder Films" class="partner-logo" style="mix-blend-mode: multiply; filter: grayscale(100%);">
                <img src="https://placehold.co/200x80/f8f9fa/050a12?text=Windows+Production&font=montserrat" alt="Windows Production" class="partner-logo" style="mix-blend-mode: multiply; filter: grayscale(100%);">
                <img src="https://placehold.co/200x80/f8f9fa/050a12?text=Eskay+Movies&font=montserrat" alt="Eskay Movies" class="partner-logo" style="mix-blend-mode: multiply; filter: grayscale(100%);">
                <img src="https://placehold.co/200x80/f8f9fa/050a12?text=Camellia+Films&font=montserrat" alt="Camellia Films" class="partner-logo" style="mix-blend-mode: multiply; filter: grayscale(100%);">
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
    gap: 0px;
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
