<?php 
$pageTitle = "Contact Us";
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php'; 
require_once 'includes/navbar.php'; 
?>

<section class="section-padding py-large bg-white text-black mt-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-uppercase red fw-bold mb-2">Get in Touch</h6>
            <h2 class="section-title mb-4">CONTACT <span class="red">IBIFF INDIA</span></h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Have questions about submissions, tickets, or sponsorships? Reach out to our dedicated festival team.</p>
        </div>

        <?php if($msg = getFlash('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?php echo $msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if($msg = getFlash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-5" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> <?php echo $msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="p-5 bg-light h-100 rounded-4">
                    <h3 class="fw-900 text-uppercase mb-4">Contact Info</h3>
                    <div class="d-flex mb-4">
                        <div class="bg-red text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                            <i class="fas fa-map-marker-alt fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-uppercase">Our Location</h6>
                            <p class="text-muted small mb-0">P-191A C.I.T Road, Scheme IVM, Phool Bagan, Kolkata - 700010</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="bg-red text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                            <i class="fas fa-phone-alt fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-uppercase">Call Us</h6>
                            <p class="text-muted small mb-0">+91 9674933641</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="bg-red text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                            <i class="fas fa-envelope fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-uppercase">Email Us</h6>
                            <p class="text-muted small mb-0">info@ibiffindia.com</p>
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <h6 class="fw-bold mb-3 text-uppercase">Follow the Festival</h6>
                        <div class="social-links d-flex gap-3">
                            <a href="https://www.facebook.com/share/1H4aNTKbbE/" target="_blank" class="btn btn-dark btn-sm rounded-circle"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/p/DWvcu6FEhbg/?igsh=YmF6czJncjRsMTky" target="_blank" class="btn btn-dark btn-sm rounded-circle"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="btn btn-dark btn-sm rounded-circle"><i class="fab fa-twitter"></i></a>
                            <a href="https://youtube.com/@ibiffindia?si=bNemnijEP6h3tbXH" target="_blank" class="btn btn-dark btn-sm rounded-circle"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7" data-aos="fade-left">
                <div class="p-5 border border-light shadow-sm rounded-4 bg-white">
                    <form action="process-contact.php" method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label small text-muted text-uppercase fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control border-light-subtle p-3" placeholder="Enter your name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted text-uppercase fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control border-light-subtle p-3" placeholder="Enter your email" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small text-muted text-uppercase fw-bold">Subject</label>
                                <input type="text" name="subject" class="form-control border-light-subtle p-3" placeholder="How can we help?" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small text-muted text-uppercase fw-bold">Message</label>
                                <textarea name="message" class="form-control border-light-subtle p-3" rows="5" placeholder="Write your detailed message here..." required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-premium btn-red w-100 py-3">SEND MESSAGE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.form-control:focus {
    border-color: var(--primary-red);
    box-shadow: none;
}
.btn-dark {
    width: 40px; height: 40px;
    display: flex; align-items: center; justify-content: center;
}
</style>

<?php require_once 'includes/footer.php'; ?>
