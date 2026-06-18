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
            <p class="lead opacity-75 text-uppercase fw-bold" style="letter-spacing: 3px;">Bridging the cinematic gap between India and Bangladesh.</p>
        </div>
    </div>
</section>

<section class="py-large bg-white text-black">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h6 class="text-uppercase red fw-bold mb-3">Festival History</h6>
                <h2 class="section-title mb-4">THE HEART OF <span class="red">IBIFF INDIA</span></h2>
                <p class="mb-4">The journey of our "Indo Bangla International Film Festival" began in June–July 2016. Reaching the people of rural Bengal through cinema in places like Amlajora, Durgapur, and Barakar in Bardhaman was truly a memorable milestone for us. From the very beginning, our vision has been to build a cultural bridge between India and Bangladesh through the medium of film, art, and culture.</p>
                <p class="mb-4">In 2017, we organized a one-day film festival at Vidyasagar Sabha Griha in Barasat, North 24 Parganas. The event was graced by filmmakers, artists, and cultural personalities from both Bangladesh and West Bengal. Notable guests included Bangladeshi actress Tanima Sen, actor Yuvraj Khan, along with many other distinguished personalities from the world of cinema and culture.</p>
                <p class="mb-4">Since its inception, our festival has always given special importance to poets, writers, and literary personalities. Over the years, the festival has evolved into a vibrant platform that brings together filmmakers, artists, and lovers of culture. We have been honored by the presence of legendary actress and Mahanayika Sabitri Chatterjee, Bodhisattva Majumdar, Abhik Bhattacharya, Santwana Basu, as well as many renowned actors, actresses, and musicians who have attended our events as special guests.</p>
                <p class="mb-4">Our festival has showcased films created by filmmakers from different parts of India and various countries around the world. Even during the global COVID-19 pandemic in 2020, when the world came to a standstill, we continued our mission without interruption. From that time onward, we began organizing online screenings while also continuing our offline activities regularly.</p>
                
                <div class="p-4 border-start border-4 border-red bg-light mt-5">
                    <h5 class="fw-900 text-uppercase mb-3">Our Mission</h5>
                    <p class="mb-0 fs-5 italic">"The primary goal of our film festival has always been to ensure that filmmakers receive the recognition, respect, and appreciation they truly deserve. With a commitment to celebrating creativity, culture, and cinematic excellence, we continue to move forward—bringing together emerging talents, visionary storytellers, and cinema lovers from across the globe."</p>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative">
                    <img src="assets/images/festival-poster.png" class="img-fluid shadow-lg" alt="Festival Poster" style="border-radius: 4px;">
                    <div class="experience-box bg-red text-white p-4 position-absolute bottom-0 start-0 m-4 shadow">
                        <h2 class="mb-0 fw-900">2024</h2>
                        <p class="mb-0 small fw-bold">OCTOBER EDITION</p>
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
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm p-5 text-center h-100">
                    <div class="icon-box bg-red text-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-fingerprint fa-2x"></i>
                    </div>
                    <h4 class="fw-900 text-uppercase mb-3">Authenticity</h4>
                    <p class="text-muted mb-0">We value original voices and authentic storytelling that reflects the true spirit of culture and society.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm p-5 text-center h-100">
                    <div class="icon-box bg-red text-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h4 class="fw-900 text-uppercase mb-3">Inclusivity</h4>
                    <p class="text-muted mb-0">Our platform is open to all, regardless of background, gender, or experience level. Diversity is our strength.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm p-5 text-center h-100">
                    <div class="icon-box bg-red text-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-award fa-2x"></i>
                    </div>
                    <h4 class="fw-900 text-uppercase mb-3">Excellence</h4>
                    <p class="text-muted mb-0">We strive for excellence in every aspect of the festival, from curation to the final award ceremony.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.bg-red { background-color: var(--primary-red); }
.border-red { border-color: var(--primary-red) !important; }
.fw-900 { font-weight: 900; }
</style>

<?php require_once 'includes/footer.php'; ?>
