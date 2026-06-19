<?php 
$pageTitle = "Festival Info - Schedule";
require_once 'includes/header.php'; 
require_once 'includes/navbar.php'; 
require_once 'includes/db.php';

// Fetch Schedule grouped by date
$allEvents = [];
if ($db) {
    $stmt = $db->query("SELECT * FROM festival_schedule ORDER BY event_date ASC, start_time ASC");
    $allEvents = $stmt->fetchAll();
}

$groupedEvents = [];
foreach ($allEvents as $event) {
    $groupedEvents[$event['event_date']][] = $event;
}

// Fetch all sponsor logos grouped by event_id
$logosByEvent = [];
if ($db) {
    try {
        $stmtLogos = $db->query("SELECT * FROM festival_sponsors");
        $allLogos = $stmtLogos->fetchAll();
        foreach ($allLogos as $l) {
            $logosByEvent[$l['festival_id']][] = $l;
        }
    } catch (PDOException $e) {
        // Ignored if table missing
    }
}
?>

<!-- Cinematic Page Header -->
<section class="hero-section" style="background-image: url('assets/images/hero-bg.png'); min-height: 50vh;">
    <div class="hero-bg-overlay"></div>
    <div class="container hero-content text-center">
        <h1 class="hero-title" style="font-size: 5rem;">
            <?php 
            $festTitle = getSetting('festinfo_page_title', 'FESTIVAL INFO');
            $parts = explode(' ', $festTitle);
            if (count($parts) > 1) {
                $last = array_pop($parts);
                echo htmlspecialchars(implode(' ', $parts)) . ' <span class="red">' . htmlspecialchars($last) . '</span>';
            } else {
                echo htmlspecialchars($festTitle);
            }
            ?>
        </h1>
        <p class="lead text-white fw-bold" style="letter-spacing: 5px;"><?php echo htmlspecialchars(getSetting('festinfo_page_subtitle', 'SCREENINGS, TALKS & MASTERCLASSES')); ?></p>
    </div>
</section>

<section class="section-padding py-large bg-white text-black">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-uppercase red fw-bold mb-2">Schedule</h6>
            <h2 class="section-title mb-4"><?php echo htmlspecialchars(getSetting('festinfo_schedule_title', 'FESTIVAL PROGRAM')); ?></h2>
            <p class="text-muted mx-auto" style="max-width: 600px;"><?php echo htmlspecialchars(getSetting('festinfo_schedule_text', 'Experience the best of world cinema. Join us for screenings, masterclasses, and exclusive Q&A sessions.')); ?></p>
        </div>

        <div class="timeline-container mt-5">
            <?php if (empty($groupedEvents)): ?>
                <div class="text-center py-5">
                    <p class="text-muted">Festival schedule for the 2024 edition will be announced soon.</p>
                    <a href="index.php" class="btn btn-premium btn-red mt-3">Back to Home</a>
                </div>
            <?php else: 
                $dayCount = 1;
                foreach($groupedEvents as $date => $events):
            ?>
            <div class="timeline-day-block mb-5" data-aos="fade-up">
                <div class="row align-items-center mb-4">
                    <div class="col-auto">
                        <div class="day-badge bg-red text-white p-3 fw-900 text-center" style="width: 80px;">
                            <span class="d-block small text-uppercase">Day</span>
                            <span class="h3 mb-0"><?php echo $dayCount++; ?></span>
                        </div>
                    </div>
                    <div class="col">
                        <h3 class="mb-0 fw-bold"><?php echo date("F d, Y", strtotime($date)); ?></h3>
                        <div class="h5 text-muted mb-0"><?php echo date("l", strtotime($date)); ?></div>
                    </div>
                </div>
                
                <div class="schedule-list ms-4 ps-4 border-start border-2 border-light">
                    <?php foreach($events as $event): ?>
                    <div class="schedule-item mb-4" data-aos="fade-left">
                        <div class="glass-card bg-light border-0 shadow-sm p-4">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <div class="text-red fw-900 h4 mb-0"><?php echo date("H:i", strtotime($event['start_time'])); ?></div>
                                    <div class="small text-muted text-uppercase fw-bold">GMT+5:30</div>
                                </div>
                                <div class="col-md-7">
                                    <h4 class="fw-bold mb-1"><?php echo htmlspecialchars($event['title']); ?></h4>
                                    <div class="d-flex align-items-center text-muted small mb-3">
                                        <i class="fas fa-map-marker-alt red me-2"></i> 
                                        <span class="fw-bold"><?php echo htmlspecialchars($event['venue']); ?></span>
                                        <span class="mx-2">|</span>
                                        <span><?php echo htmlspecialchars($event['hall']); ?></span>
                                    </div>
                                    
                                    <?php if(!empty($event['organizer']) || !empty($event['organizer_partner'])): ?>
                                        <div class="small mb-3 text-secondary fw-bold text-uppercase" style="letter-spacing: 1px;">
                                            <?php if(!empty($event['organizer'])): ?>
                                                Organized by: <span class="text-dark"><?php echo htmlspecialchars($event['organizer']); ?></span>
                                            <?php endif; ?>
                                            <?php if(!empty($event['organizer_partner'])): ?>
                                                <span class="mx-2">|</span> Partner: <span class="text-dark"><?php echo htmlspecialchars($event['organizer_partner']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($event['description']): ?>
                                        <p class="mb-4 text-muted small"><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                                    <?php endif; ?>

                                    <?php if(!empty($event['directions'])): ?>
                                        <div class="mb-4 p-3 bg-white rounded border-start border-3 border-danger shadow-sm">
                                            <h6 class="fw-bold mb-1"><i class="fas fa-directions me-2 text-danger"></i>Directions</h6>
                                            <p class="mb-0 small text-muted"><?php echo nl2br(htmlspecialchars($event['directions'])); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(!empty($event['map_embed_url'])): ?>
                                        <div class="ratio ratio-21x9 mb-4 rounded overflow-hidden shadow-sm">
                                            <iframe src="<?php echo htmlspecialchars($event['map_embed_url']); ?>" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($logosByEvent[$event['id']])): ?>
                                        <div class="mt-4 border-top pt-3">
                                            <h6 class="fw-bold text-muted small text-uppercase mb-3" style="letter-spacing: 1px;">Sponsored By</h6>
                                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                                <?php foreach($logosByEvent[$event['id']] as $logo): ?>
                                                    <img src="<?php echo htmlspecialchars($logo['logo_path']); ?>" alt="Sponsor" class="img-fluid" style="max-height: 50px; opacity: 0.8; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </div>
                                <div class="col-md-3 text-md-end mt-4 mt-md-0 d-flex flex-column align-items-md-end justify-content-center h-100">
                                    <span class="badge bg-dark p-2 px-3 text-uppercase mb-3 d-inline-block">Official Event</span>
                                    <?php if(!empty($event['tickets_url'])): ?>
                                        <a href="<?php echo htmlspecialchars($event['tickets_url']); ?>" target="_blank" class="btn btn-gold fw-bold px-4 py-2 text-uppercase shadow-sm" style="letter-spacing: 1px; border-radius: 30px;">
                                            <i class="fas fa-ticket-alt me-2"></i> Buy Tickets
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>

<style>
.day-badge { border-radius: 4px; }
.bg-red { background-color: var(--primary-red); }
.text-red { color: var(--primary-red); }
.schedule-item { position: relative; }
.schedule-item::before {
    content: '';
    position: absolute;
    left: -29px;
    top: 25px;
    width: 12px;
    height: 12px;
    background: var(--primary-red);
    border-radius: 50%;
    z-index: 2;
}
</style>

<?php require_once 'includes/footer.php'; ?>
