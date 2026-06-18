<?php 
require_once 'includes/header.php';

if (!isAdminLoggedIn()) {
    redirect('login.php');
}

// Fetch Messages
$stmt = $db->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>

<div class="sidebar">
    <div class="p-4 mb-3 border-bottom border-secondary border-opacity-25">
        <h4 class="fw-bold mb-0">IBIFF <span class="gold">INDIA</span></h4>
        <small class="text-muted">Admin Panel</small>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        <a class="nav-link" href="films/index.php"><i class="fas fa-film me-2"></i> Manage Films</a>
        <a class="nav-link" href="gallery/index.php"><i class="fas fa-images me-2"></i> Manage Gallery</a>
        <a class="nav-link" href="festival/index.php"><i class="fas fa-calendar-alt me-2"></i> Festival Schedule</a>
        <a class="nav-link active" href="messages.php"><i class="fas fa-envelope me-2"></i> Messages</a>
        <a class="nav-link" href="settings.php"><i class="fas fa-cog me-2"></i> Settings</a>
        <div class="mt-auto p-4">
            <a class="btn btn-outline-danger btn-sm w-100" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </div>
    </nav>
</div>

<main class="main-content">
    <div class="mb-5">
        <h2 class="fw-bold">Contact Messages</h2>
        <p class="text-muted">View and manage inquiries from website visitors.</p>
    </div>

    <div class="card admin-card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>Sender</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($messages)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No messages yet.</td>
                            </tr>
                        <?php else: foreach($messages as $msg): ?>
                            <tr>
                                <td class="ps-4 small text-muted"><?php echo formatDate($msg['created_at'], "d M, H:i"); ?></td>
                                <td>
                                    <div class="fw-bold"><?php echo $msg['name']; ?></div>
                                    <small class="text-muted"><?php echo $msg['email']; ?></small>
                                </td>
                                <td><span class="badge bg-gold text-dark"><?php echo $msg['subject']; ?></span></td>
                                <td><div class="small text-truncate" style="max-width: 300px;"><?php echo $msg['message']; ?></div></td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#msgModal<?php echo $msg['id']; ?>"><i class="fas fa-eye"></i></button>
                                </td>
                            </tr>
                            
                            <!-- Message View Modal -->
                            <div class="modal fade" id="msgModal<?php echo $msg['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Message from <?php echo $msg['name']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <small class="text-muted text-uppercase fw-bold d-block">Subject</small>
                                                <div class="fw-bold"><?php echo $msg['subject']; ?></div>
                                            </div>
                                            <div class="mb-3">
                                                <small class="text-muted text-uppercase fw-bold d-block">Email</small>
                                                <div class="text-primary"><?php echo $msg['email']; ?></div>
                                            </div>
                                            <div class="mb-0">
                                                <small class="text-muted text-uppercase fw-bold d-block mb-1">Message</small>
                                                <div class="bg-light p-3 rounded"><?php echo nl2br($msg['message']); ?></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="mailto:<?php echo $msg['email']; ?>" class="btn btn-gold w-100">Reply via Email</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
