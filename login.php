<?php
// ====================================================================
// PROJECT NAME: TrainHub Railway System
// FILE NAME: login.php
// DESCRIPTION: Secure Passenger Login with Smart URL Redirection
// ====================================================================

// 1. Session එක ආරම්භ කිරීම (දැනටමත් ආරම්භ වී නොමැති නම් පමණක්)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 2. දත්ත ගබඩා සම්බන්ධතාවය (Database Config) සහ Header Layout එක එකතු කිරීම
require_once 'config/db.php';
include_once 'includes/header.php';

$error_msg = "";

// 3. මගියා Login Form එක Submit කළ පසු ක්‍රියාත්මක වන කොටස (POST Method)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Input Validation සහ ආරක්ෂාව සඳහා හිස්තැන් ඉවත් කිරීම (Trim)
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        // ඩේටාබේස් එකෙන් අදාළ ඊමේල් ලිපිනය ඇති පරිශීලකයා සෙවීම
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // පරිශීලකයා පද්ධතියේ සිටී නම් සහ මුරපදය නිවැරදි නම් (Password Verification)
        if ($user && password_verify($password, $user['password'])) {
            
            // සෙෂන් (Session) දත්ත සුරක්ෂිතව ගබඩා කිරීම
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_role'] = $user['role'];

            // පරිශීලකයා පරිපාලකයෙකු (Admin) නම් ඇඩ්මින් පැනල් එකට යැවීම
            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                // [විශේෂාංගය]: මගියා කලින් "Book Now" ක්ලික් කර පැමිණි අයෙකු නම් ඔහුව නැවත එම බුකින් පිටුවටම යැවීම
                if (isset($_SESSION['redirect_url'])) {
                    $redirect_target = $_SESSION['redirect_url'];
                    unset($_SESSION['redirect_url']); // භාවිතයෙන් පසු සෙෂන් එක හිස් කිරීම
                    header("Location: " . $redirect_target);
                } else {
                    // සාමාන්‍ය ලොගින් එකක් නම් කෙලින්ම මුල් පිටුවට (Home Page)
                    header("Location: index.php");
                }
            }
            exit(); // කේතය ක්‍රියාත්මක වීම මෙතැනින් නැවතීම
            
        } else {
            // මුරපදය හෝ ඊමේල් වැරදි නම් පෙන්වන පණිවිඩය
            $error_msg = "ඇතුළත් කළ ඊමේල් ලිපිනය හෝ මුරපදය වැරදියි! කරුණාකර නැවත පරීක්ෂා කරන්න.";
        }
    } catch (\PDOException $e) {
        $error_msg = "පද්ධතියේ දෝෂයක් පවතී: " . $e->getMessage();
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center align-items-center" style="min-height: 60vh;">
        <div class="col-md-5">
            <div class="card shadow border-0 p-4 bg-white rounded-3">
                
                <div class="text-center mb-4">
                    <div class="text-info display-5 mb-2">
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </div>
                    <h3 class="fw-bold text-dark m-0">ඇතුළු වීම (Login)</h3>
                    <p class="small text-muted mt-1">TrainHub ගිණුමට ඇතුළු වී ඔබේ දුම්රිය ආසන වෙන් කරවා ගන්න.</p>
                </div>
                
                <?php if(!empty($error_msg)): ?>
                    <div class="alert alert-danger d-flex align-items-center small py-2 shadow-sm" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2 fs-6"></i>
                        <div><?php echo $error_msg; ?></div>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">ඊමේල් ලිපිනය (Email Address)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-secondary-subtle"><i class="fa fa-envelope text-muted small"></i></span>
                            <input type="email" name="email" class="form-control border-secondary-subtle" placeholder="name@example.com" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">මුරපදය (Password)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-secondary-subtle"><i class="fa fa-lock text-muted small"></i></span>
                            <input type="password" name="password" class="form-control border-secondary-subtle" placeholder="••••••••" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-dark w-100 fw-bold text-info py-2 mt-2 shadow-sm text-uppercase">
                        <i class="fa-solid fa-circle-check me-2"></i>Log In
                    </button>
                </form>
                
                <div class="text-center mt-4 border-top pt-3 border-light-subtle">
                    <p class="small text-muted mb-1">
                        <a href="forgot_password.php" class="text-decoration-none text-secondary">Forgot Password</a>
                    </p>
                    <p class="small text-muted m-0">
                        තවමත් ගිණුමක් නොමැතිද? <a href="register.php" class="text-info fw-bold text-decoration-none">Register Now</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

<?php 
// 4. Layout Footer එක සම්බන්ධ කිරීම
include_once 'includes/footer.php'; 
?>