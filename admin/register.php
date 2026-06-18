<?php 
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

// In a production environment, you might want to restrict this page 
// to only be accessible if no admins exist or by a superadmin.

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if username or email already exists
        $stmt = $db->prepare("SELECT id FROM admins WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $error = "Username or Email already exists!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO admins (name, email, username, password) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $username, $hashed_password])) {
                $success = "Admin registered successfully! <a href='login.php' class='text-gold'>Login here</a>";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration | <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0a0a0a; color: white; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif; }
        .login-card { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 15px; width: 100%; max-width: 450px; padding: 2.5rem; }
        .gold { color: #d4af37; }
        .btn-gold { background-color: #d4af37; color: #000; font-weight: bold; }
        .btn-gold:hover { background-color: #f1c40f; }
        .form-control { background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); color: white; padding: 0.8rem; }
        .form-control:focus { background: rgba(0,0,0,0.5); border-color: #d4af37; color: white; box-shadow: none; }
    </style>
</head>
<body>
    <div class="login-card my-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-1">IBIFF <span class="gold">INDIA</span></h2>
            <p class="text-muted small text-uppercase">Admin Registration</p>
        </div>
        
        <?php if($error): ?>
            <div class="alert alert-danger py-2 small"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="alert alert-success py-2 small"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label small text-muted">Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label small text-muted">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label small text-muted">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label small text-muted">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-muted">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-gold w-100 py-2">Create Admin Account</button>
            <div class="text-center mt-3">
                <a href="login.php" class="text-muted small text-decoration-none">Already have an account? Login</a>
            </div>
        </form>
    </div>
</body>
</html>
