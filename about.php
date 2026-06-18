<?php 
$pageTitle = "About Us";
require_once 'includes/header.php'; 
require_once 'includes/navbar.php'; 
?>

<!-- Simple Header -->
<section class="py-5 bg-black text-white mt-5">
    <div class="container py-5">
        <div class="text-center" data-aos="fade-up">
            <h1 class="display-3 fw-900 mb-3">OUR <span class="red">STORY</span></h1>
            <p class="lead opacity-75 text-uppercase fw-bold" style="letter-spacing: 3px;"><?php echo htmlspecialchars(getSetting('about_tagline', 'Bridging the cinematic gap between India and Bangladesh.')); ?></p>
        </div>
    </div>
</section>

<section class="py-large bg-white text-black">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h6 class="text-uppercase red fw-bold mb-3">Festival History</h6>
                <h2 class="section-title mb-4">
                    <?php 
                    $historyTitle = getSetting('about_history_title', 'THE HEART OF IBIFF INDIA');
                    $parts = explode(' ', $historyTitle);
                    if (count($parts) > 1) {
                        $last = array_pop($parts);
                        echo htmlspecialchars(implode(' ', $parts)) . ' <span class="red">' . htmlspecialchars($last) . '</span>';
                    } else {
                        echo htmlspecialchars($historyTitle);
                    }
                    ?>
                </h2>
                <p class="mb-4"><?php echo nl2br(htmlspecialchars(getSetting('about_history_text_1'))); ?></p>
                <p class="mb-4"><?php echo nl2br(htmlspecialchars(getSetting('about_history_text_2'))); ?></p>
                <p class="mb-4"><?php echo nl2br(htmlspecialchars(getSetting('about_history_text_3'))); ?></p>
                <p class="mb-4"><?php echo nl2br(htmlspecialchars(getSetting('about_history_text_4'))); ?></p>
                
                <div class="p-4 border-start border-4 border-red bg-light mt-5">
                    <h5 class="fw-900 text-uppercase mb-3">Our Mission</h5>
                    <p class="mb-0 fs-5 italic">"<?php echo nl2br(htmlspecialchars(getSetting('about_mission_quote'))); ?>"</p>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative">
                    <img src="<?php echo htmlspecialchars(getSetting('about_poster_image', 'assets/images/festival-poster.png')); ?>" class="img-fluid shadow-lg w-100" alt="Festival Poster" style="border-radius: 4px;">
                    <div class="experience-box bg-red text-white p-4 position-absolute bottom-0 start-0 m-4 shadow">
                        <h2 class="mb-0 fw-900"><?php echo htmlspecialchars(getSetting('about_poster_year', '2026')); ?></h2>
                        <p class="mb-0 small fw-bold"><?php echo htmlspecialchars(getSetting('about_poster_edition', 'JANUARY EDITION')); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-large bg-light text-black">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-uppercase red fw-bold mb-2">Philosophy</h6>
            <h2 class="section-title">OUR CORE <span class="red">VALUES</span></h2>
        </div>
        <div class="row g-4 mt-4">
            <?php for($i=1; $i<=3; $i++): 
                $vTitle = getSetting("about_value_{$i}_title");
                $vDesc = getSetting("about_value_{$i}_desc");
                $icons = ['fa-fingerprint', 'fa-users', 'fa-award'];
            ?>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?php echo $i*100; ?>">
                <div class="card border-0 shadow-sm p-5 text-center h-100">
                    <div class="icon-box bg-red text-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas <?php echo $icons[$i-1]; ?> fa-2x"></i>
                    </div>
                    <h4 class="fw-900 text-uppercase mb-3"><?php echo htmlspecialchars($vTitle); ?></h4>
                    <p class="text-muted mb-0"><?php echo htmlspecialchars($vDesc); ?></p>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<style>
.bg-red { background-color: var(--primary-red); }
.border-red { border-color: var(--primary-red) !important; }
.fw-900 { font-weight: 900; }
</style>

<?php require_once 'includes/footer.php'; ?>
