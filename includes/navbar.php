<?php require_once __DIR__ . '/config.php'; ?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top main-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="<?php echo htmlspecialchars($siteLogo); ?>" alt="IBIFF INDIA Logo" class="brand-logo me-2" height="60">
        </a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fas fa-bars" style="color: var(--light-cream); font-size: 1.5rem;"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="films.php">Films</a></li>
                <li class="nav-item"><a class="nav-link" href="photos.php">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="festivalinfo.php">Festival Info</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-red px-4 py-2 fw-bold rounded-0" href="<?php echo htmlspecialchars(getSetting('submit_film_link', 'https://filmfreeway.com')); ?>" target="_blank">SUBMIT FILM</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
