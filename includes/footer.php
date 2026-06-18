<footer class="footer py-large text-white">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h3 class="fw-900 mb-4">IBIFF <span class="red">INDIA</span></h3>
                <p class="text-white-50 mb-4 opacity-75">Indo-Bangla International Film Festival. Bridging cultures through the art of cinema. Join us for a journey of storytelling excellence.</p>
                <div class="social-links d-flex gap-3">
                    <a href="https://www.facebook.com/share/1H4aNTKbbE/" target="_blank" class="text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/p/DWvcu6FEhbg/?igsh=YmF6czJncjRsMTky" target="_blank" class="text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                    <a href="https://youtube.com/@ibiffindia?si=bNemnijEP6h3tbXH" target="_blank" class="text-white"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2 ms-auto">
                <h6 class="mb-4 fw-900 text-uppercase red">Quick Links</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="index.php" class="text-white-50 text-decoration-none small fw-bold">HOME</a></li>
                    <li><a href="about.php" class="text-white-50 text-decoration-none small fw-bold">ABOUT US</a></li>
                    <li><a href="films.php" class="text-white-50 text-decoration-none small fw-bold">FILMS</a></li>
                    <li><a href="photos.php" class="text-white-50 text-decoration-none small fw-bold">GALLERY</a></li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h6 class="mb-4 fw-900 text-uppercase red">Festival</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="festivalinfo.php" class="text-white-50 text-decoration-none small fw-bold">SCHEDULE</a></li>
                    <li><a href="contact.php" class="text-white-50 text-decoration-none small fw-bold">CONTACT</a></li>
                    <li><a href="https://filmfreeway.com" class="text-white-50 text-decoration-none small fw-bold">SUBMIT FILM</a></li>
                    <li><a href="privacy.php" class="text-white-50 text-decoration-none small fw-bold">PRIVACY</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="mb-4 fw-900 text-uppercase red">Contact Info</h6>
                <ul class="list-unstyled footer-contact small fw-bold">
                    <li class="mb-2 text-white-50"><i class="fas fa-map-marker-alt red me-2"></i> KOLKATA, INDIA</li>
                    <li class="mb-2 text-white-50"><i class="fas fa-phone-alt red me-2"></i> +91 9674933641</li>
                    <li class="mb-2 text-white-50"><i class="fas fa-envelope red me-2"></i> INFO@IBIFFINDIA.COM</li>
                </ul>
            </div>
        </div>
        <hr class="my-5 opacity-10">
        <div class="text-center">
            <p class="mb-0 text-white-50 small fw-bold">&copy; <?php echo date('Y'); ?> IBIFF INDIA (INDO-BANGLA INTERNATIONAL FILM FESTIVAL). ALL RIGHTS RESERVED.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="assets/js/main.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });

    // Initialize Top Hero Slider
    if (typeof Swiper !== 'undefined') {
        new Swiper('.topHeroSlider', {
            loop: true,
            effect: 'fade',
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
</script>
</body>
</html>
