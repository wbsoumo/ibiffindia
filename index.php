<?php 
$pageTitle = "IBIFF INDIA | Indo-Bangla International Film Festival";
require_once 'includes/header.php'; 
require_once 'includes/navbar.php'; 
require_once 'includes/db.php';

// Fetch Featured Films (Last 4)
$featuredFilms = [];
if ($db) {
    $stmt = $db->query("SELECT * FROM films ORDER BY created_at DESC LIMIT 4");
    $featuredFilms = $stmt->fetchAll();
}
?>

<!-- Cinematic Hero Section -->
<section class="hero-section" style="background-image: url('assets/images/hero-bg.png');">
    <div class="hero-bg-overlay"></div>
    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-12 text-center" data-aos="fade-up">
                <span class="section-tag mb-4" data-aos="fade-down" data-aos-delay="200">Official 2025 Edition</span>
                <h1 class="hero-title" style="font-family: 'Cinzel', serif; font-weight: 900;">IBIFF <span class="red">INDIA</span></h1>
                <p class="lead mb-5 text-light fw-bold" style="letter-spacing: 6px; font-size: 1.1rem; text-transform: uppercase;">Celebrating Cinematic Excellence Across Borders</p>
                <div class="hero-btns mt-5">
                    <a href="films.php" class="btn btn-premium btn-red me-3">EXPLORE FESTIVAL</a>
                    <a href="https://filmfreeway.com" target="_blank" class="btn btn-premium btn-outline-white">SUBMIT YOUR FILM</a>
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

<!-- Welcome & Edition Section (Two-Column Reference Replicated) -->
<section class="welcome-section py-large bg-white text-dark">
    <div class="container">
        <div class="row align-items-stretch">
            <div class="col-lg-7 pe-lg-5" data-aos="fade-right">
                <p class="text-danger fw-bold mb-2">Welcome to</p>
                <h2 class="welcome-title-large mb-4">
                    <span class="text-danger">THE INTERNATIONAL</span> <br>
                    <span class="text-dark">INDO-BANGLA FILM FESTIVAL</span> <br>
                    <span class="text-danger">IBIFF INDIA</span>
                </h2>
                <ul class="list-unstyled welcome-list mb-5">
                    <li>An internationally acclaimed platform celebrating independent cinema</li>
                    <li>A vibrant hybrid ecosystem connecting filmmakers, cinephiles, and creators</li>
                    <li>Diverse genres, formats, and storytelling styles encouraged</li>
                    <li>A festival rooted in creativity, collaboration, and cultural exchange</li>
                </ul>
                <div class="content-box mb-5">
                    <h5 class="fw-bold mb-3">8th International Indo-Bangla Film Festival (IBIFF) 2025!</h5>
                    <p class="text-muted">The International Indo-Bangla Film Festival (IBIFF) 2024 concluded successfully, marking yet another milestone in our journey of celebrating cinema from across the globe. We now look forward to the next edition — IBIFF 2026.</p>
                </div>
                <a href="about.php" class="btn btn-premium btn-red">DISCOVER MORE</a>
            </div>
            <div class="col-lg-5 mt-5 mt-lg-0" data-aos="fade-left">
                <div class="welcome-poster-section shadow-lg">
                    <h3>IBIFF 2026 EDITION</h3>
                    <img src="assets/images/poster1.jpg" alt="IBIFF 2025 Poster" class="img-fluid mb-4 w-100">
                    <div class="stats-mini row g-0 text-center border-top pt-4">
                        <div class="col-6 border-end">
                            <h4 class="fw-900 mb-0">50+</h4>
                            <p class="small text-muted mb-0">Categories</p>
                        </div>
                        <div class="col-6">
                            <h4 class="fw-900 mb-0">200+</h4>
                            <p class="small text-muted mb-0">Selections</p>
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
                <img src="assets/images/poster.jpg" alt="IBIFF Mission" class="img-fluid">
            </div>
            <div class="col-lg-7 overlap-content text-dark" data-aos="fade-left">
                <span class="section-tag text-muted">Our Vision</span>
                <h2 class="section-heading text-dark">BRIDGING CULTURES <br>THROUGH <span class="red">CINEMA</span></h2>
                <p class="lead text-dark mb-4">The Indo-Bangla International Film Festival (IBIFF) is dedicated to fostering creative exchange and celebrating the art of storytelling.</p>
                <p class="text-muted mb-5">Over the years, IBIFF has evolved into a trusted international platform for short films, documentaries, and experimental cinema. We bring together a diverse community of filmmakers and audiences to celebrate the power of the moving image.</p>
                <div class="d-flex gap-4 mb-5">
                    <div class="feature-item">
                        <i class="fas fa-trophy fa-2x red mb-2"></i>
                        <h6 class="fw-bold text-dark">Global Reach</h6>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-link fa-2x red mb-2"></i>
                        <h6 class="fw-bold text-dark">Creative Synergy</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News & Highlights Marquee -->
<section class="bg-black py-5 overflow-hidden border-top border-bottom border-secondary border-opacity-25">
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
                <span class="section-tag text-muted">Why Join Us?</span>
                <h2 class="section-heading text-dark">A PLATFORM FOR <br><span class="red">VISIONARIES</span></h2>
                <p class="lead text-dark mb-5">Join the fastest growing film festival network in the Indo-Bangla region. We offer more than just a screening; we offer a career-defining ecosystem.</p>
                
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="icon-circle bg-light p-3 rounded-circle">
                                <i class="fas fa-globe-asia red fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">Global Exposure</h6>
                                <p class="small text-muted mb-0">Reach audiences across 30+ countries.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="icon-circle bg-light p-3 rounded-circle">
                                <i class="fas fa-handshake red fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">CineBridge</h6>
                                <p class="small text-muted mb-0">Direct access to industry investors.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="icon-circle bg-light p-3 rounded-circle">
                                <i class="fas fa-graduation-cap red fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">Masterclasses</h6>
                                <p class="small text-muted mb-0">Learn from award-winning directors.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="icon-circle bg-light p-3 rounded-circle">
                                <i class="fas fa-star red fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">50+ Awards</h6>
                                <p class="small text-muted mb-0">Prestigious laurels for your work.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="row g-3 mesh-mimic">
                    <div class="col-6 mesh-item">
                        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=400" alt="Festival" class="img-fluid shadow rounded">
                    </div>
                    <div class="col-6 mesh-item pt-5">
                        <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=400" alt="Festival" class="img-fluid shadow rounded">
                    </div>
                    <div class="col-12 mesh-item">
                        <img src="https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=600" alt="Festival" class="img-fluid shadow rounded">
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
            <span class="section-tag">Selection 2024</span>
            <h2 class="section-heading text-white">FESTIVAL <span class="red">HIGHLIGHTS</span></h2>
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
                <a href="film.php?id=<?php echo $film['id']; ?>">
                    <div class="film-card-premium">
                        <img src="<?php echo strpos($film['poster'], 'http') === 0 ? $film['poster'] : 'assets/uploads/posters/'.$film['poster']; ?>" 
                             onerror="this.src='https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800'" alt="<?php echo $film['title']; ?>">
                        <div class="film-card-info">
                            <span class="badge bg-red mb-2"><?php echo $film['genre']; ?></span>
                            <h4><?php echo $film['title']; ?></h4>
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
<section class="cinebridge-section" style="background-image: url('assets/images/cinebridge-bg.png');">
    <div class="cinebridge-overlay"></div>
    <div class="container position-relative z-index-2 text-center text-white" data-aos="zoom-in">
        <span class="section-tag text-white">Film Marketplace</span>
        <h2 class="display-3 fw-900 mb-4" style="font-family: 'Cinzel', serif;">CINEBRIDGE <span class="red">INDIA</span></h2>
        <p class="lead mb-5 max-w-700 mx-auto opacity-75">Where creators meet collaborators. Connect with international producers, distributors, and investors to take your project to the global stage.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="about.php#cinebridge" class="btn btn-premium btn-red">JOIN AS FILMMAKER</a>
            <a href="contact.php" class="btn btn-premium btn-outline-white">JOIN AS INVESTOR</a>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="text-center py-5 bg-white overflow-hidden">
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
    padding-right: 100px; /* ensure gap before next track */
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
</style>

<?php require_once 'includes/footer.php'; ?>
