<?php 
require_once '../includes/header.php';

if (!isAdminLoggedIn()) {
    redirect('../login.php');
}

$events = [];
if ($db) {
    $stmt = $db->query("SELECT * FROM festival_schedule ORDER BY event_date ASC, start_time ASC");
    $events = $stmt->fetchAll();
}
?>

<div class="sidebar">
    <div class="p-4 mb-3 border-bottom border-secondary border-opacity-25">
        <h4 class="fw-bold mb-0">IBIFF <span class="gold">INDIA</span></h4>
        <small class="text-muted">Admin Panel</small>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link" href="../dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        <a class="nav-link" href="../films/index.php"><i class="fas fa-film me-2"></i> Manage Films</a>
        <a class="nav-link" href="../gallery/index.php"><i class="fas fa-images me-2"></i> Manage Gallery</a>
        <a class="nav-link active" href="index.php"><i class="fas fa-calendar-alt me-2"></i> Festival Schedule</a>
        <a class="nav-link" href="../messages.php"><i class="fas fa-envelope me-2"></i> Messages</a>
        <a class="nav-link" href="../settings.php"><i class="fas fa-cog me-2"></i> Settings</a>
        <div class="mt-auto p-4">
            <a class="btn btn-outline-danger btn-sm w-100" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </div>
    </nav>
</div>

<main class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Festival Schedule</h2>
        <a href="add.php" class="btn btn-gold"><i class="fas fa-plus me-2"></i> Add Event</a>
    </div>

    <?php if($msg = getFlash('success')): ?>
        <div class="alert alert-success"><?php echo $msg; ?></div>
    <?php endif; ?>

    <div class="card admin-card p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Event Title</th>
                        <th>Venue</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($events)): ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">No events scheduled.</td></tr>
                    <?php else: foreach($events as $event): ?>
                    <tr>
                        <td><?php echo date("M d, Y", strtotime($event['event_date'])); ?></td>
                        <td><?php echo date("H:i", strtotime($event['start_time'])); ?> - <?php echo date("H:i", strtotime($event['end_time'])); ?></td>
                        <td class="fw-bold"><?php echo htmlspecialchars($event['title']); ?></td>
                        <td><?php echo htmlspecialchars($event['venue']); ?></td>
                        <td>
                            <a href="delete.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this event?');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
