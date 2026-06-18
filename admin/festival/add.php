<?php 
require_once '../includes/header.php';



$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $event_date = sanitize($_POST['event_date']);
    $start_time = sanitize($_POST['start_time']);
    $end_time = sanitize($_POST['end_time']);
    $venue = sanitize($_POST['venue']);
    $hall = sanitize($_POST['hall']);
    $description = sanitize($_POST['description']);

    if (empty($title) || empty($event_date) || empty($start_time)) {
        $error = "Title, Date, and Start Time are required.";
    } else {
        if ($db) {
            $stmt = $db->prepare("INSERT INTO festival_schedule (title, event_date, start_time, end_time, venue, hall, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$title, $event_date, $start_time, $end_time, $venue, $hall, $description])) {
                setFlash('success', 'Event added successfully.');
                redirect('index.php');
            } else {
                $error = "Failed to add event.";
            }
        }
    }
}
?>

<section class="content"><div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Add New Event</h2>
        <a href="index.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Back</a>
    </div>

    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card card p-4">
        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Event Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Event Date</label>
                    <input type="date" name="event_date" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Start Time</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">End Time</label>
                    <input type="time" name="end_time" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Venue</label>
                    <input type="text" name="venue" class="form-control" placeholder="e.g. Main Auditorium">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Hall / Room</label>
                    <input type="text" name="hall" class="form-control" placeholder="e.g. Hall A">
                </div>
                <div class="col-md-12 mb-4">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-gold px-4 py-2">Save Event</button>
                </div>
            </div>
        </form>
    </div>
</div></section>
<?php require_once '../includes/footer.php'; ?>
