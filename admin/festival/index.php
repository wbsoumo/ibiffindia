<?php 
require_once '../includes/header.php';



$events = [];
if ($db) {
    $stmt = $db->query("SELECT * FROM festival_schedule ORDER BY event_date ASC, start_time ASC");
    $events = $stmt->fetchAll();
}
?>

<section class="content"><div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Festival Schedule</h2>
        <a href="add.php" class="btn btn-gold"><i class="fas fa-plus me-2"></i> Add Event</a>
    </div>

    <?php if($msg = getFlash('success')): ?>
        <div class="alert alert-success"><?php echo $msg; ?></div>
    <?php endif; ?>

    <div class="card card p-4">
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
                            <a href="edit.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <a href="delete.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this event?');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div></section>
<?php require_once '../includes/footer.php'; ?>
