<?php
// ====================================================================
// PROJECT NAME: TrainHub Railway System
// FILE NAME: forgot_password.php
// DESCRIPTION: Password Reset Request Page (English UI)
// ====================================================================

require_once 'includes/header.php';
require_once 'config/db.php';

$success_msg = "";
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_request'])) {
    $email = trim($_POST['email']);

    if (!empty($email)) {
        try {
            // Verify if the user email exists in the database
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                // In a production app, you would generate a token and send an email here.
                // For a local simulation project, we show a success response.
                $success_msg = "A password reset link has been simulated! Please check your database tokens or check backend logs.";
            } else {
                $error_msg = "No account found with that email address.";
            }
        } catch (\PDOException $e) {
            $error_msg = "Database error: " . $e->getMessage();
        }
    } else {
        $error_msg = "Please enter a valid email address.";
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card bg-dark text-white p-4 shadow-lg border-0 rounded-3" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-key text-warning display-4 mb-3"></i>
                    <h3 class="fw-bold text-white">Forgot Password?</h3>
                    <p class="text-white-50 small">Enter your email address below, and we will help you reset your account credentials.</p>
                </div>

                <?php if (!empty($success_msg)): ?>
                    <div class="alert alert-success py-2 small"><?php echo $success_msg; ?></div>
                <?php endif; ?>
                <?php if (!empty($error_msg)): ?>
                    <div class="alert alert-danger py-2 small"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <form action="forgot_password.php" method="POST">
                    <div class="mb-4">
                        <label class="form-label text-light small fw-bold">Registered Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-secondary text-white border-0"><i class="fa fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control bg-secondary text-white border-0" placeholder="e.g. passenger@example.com" required>
                        </div>
                    </div>

                    <button type="submit" name="reset_request" class="btn btn-info w-100 fw-bold py-2 text-dark shadow-sm mb-3">
                        Request Reset Link
                    </button>
                </form>

                <div class="text-center mt-3 border-top border-secondary pt-3 small">
                    <a href="login.php" class="text-info text-decoration-none"><i class="fa fa-arrow-left me-2"></i>Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
require_once 'includes/footer.php'; 
?>