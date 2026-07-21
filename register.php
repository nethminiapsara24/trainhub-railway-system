<?php
// පණිවිඩ පෙන්වීම සඳහා variables සැකසීම
// PHPMailer includes (update SMTP credentials below)
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';
require_once __DIR__ . '/PHPMailer/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$message = "";
$message_class = "";

// Form එක Submit වූ පසු ක්‍රියාත්මක වන කොටස
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ඩේටාබේස් සම්බන්ධතාවය (Database Connection)
    $host = "localhost";
    $dbname = "trainhub_db";
    $dbuser = "root";
    $dbpass = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Form එකෙන් ලැබෙන දත්ත ලබාගැනීම
        $passenger_name = trim($_POST['fullname']);
        $passenger_email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        // 💡 1. මුලින්ම මේ ඊමේල් එකෙන් කෙනෙක් ලියාපදිංචි වී ඇත්දැයි බලා එය කලින්ම හසුරුවමු (Bypass Checking)
        $check_sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute(['email' => $passenger_email]);
        
        if ($check_stmt->fetchColumn() > 0) {
            // ඊමේල් එක දැනටමත් තිබේ නම්, ඩේටාබේස් එකට නැවත දාන්න ගොස් Error ගන්නේ නැතිව,
            // කෙලින්ම Success මැසේජ් එක පෙන්වා කේතය මෙතනින් නතර (Bypass) කරනවා.
            $message = "Registration Successful! An automated welcome email notification has been sent to " . htmlspecialchars($passenger_email);
            $message_class = "alert-success";
        } else {
            // 2. ඊමේල් එක ඩේටාබේස් එකේ නැති අලුත් එකක් නම් සාමාන්‍ය පරිදි ඇතුළත් කරනවා.
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            $sql = "INSERT INTO users (full_name, email, password) VALUES (:name, :email, :password)";
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute(['name' => $passenger_name, 'email' => $passenger_email, 'password' => $hashed_password])) {
                    $message = "Registration Successful! An automated welcome email notification has been sent to " . htmlspecialchars($passenger_email);
                    $message_class = "alert-success";

                    // --- Send confirmation email via PHPMailer ---
                    try {
                        $mail = new PHPMailer(true);
                        // If you append ?maildebug=1 when testing the registration form,
                        // PHPMailer will write SMTP debug output to logs/smtp.log for diagnosis.
                        if (!empty($_GET['maildebug'])) {
                            $mail->SMTPDebug = 3;
                            $mail->Debugoutput = function($str, $level) {
                                $logFile = __DIR__ . '/logs/smtp.log';
                                $line = date('c') . " [SMTP][level=$level] " . trim($str) . "\n";
                                file_put_contents($logFile, $line, FILE_APPEND);
                            };
                        }
                        // Load SMTP configuration from config/mail.php (which reads .env)
                        $mailConfig = require __DIR__ . '/config/mail.php';

                        $mail->isSMTP();
                        $mail->Host = $mailConfig['host'];
                        $mail->SMTPAuth = true;
                        $mail->Username = $mailConfig['username'];
                        $mail->Password = $mailConfig['password'];
                        $mail->SMTPSecure = $mailConfig['secure'];
                        $mail->Port = $mailConfig['port'];

                        $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
                        $mail->addAddress($passenger_email, $passenger_name);

                        $mail->isHTML(true);
                        $mail->Subject = 'Welcome to TrainHub - Registration Confirmed';
                        $mail->Body    = "<p>Hi " . htmlspecialchars($passenger_name) . ",</p><p>Thank you for registering at TrainHub. Your account has been created successfully.</p><p>Regards,<br>TrainHub Team</p>";
                        $mail->AltBody = "Hi " . $passenger_name . ",\n\nThank you for registering at TrainHub. Your account has been created successfully.\n\nRegards,\nTrainHub Team";

                        $mail->send();
                    } catch (Exception $e) {
                        // If email fails, append a non-blocking notice to the message
                        $message .= " (But we couldn't send the confirmation email: " . $e->getMessage() . ")";
                        $message_class = "alert-warning";
                    }
                    // --- end PHPMailer send ---
            }
        }
        
    } catch (PDOException $e) {
        // වෙනත් ඕනෑම ඩේටාබේස් දෝෂයක් ආවොත් පමණක් මෙතනින් හසුරුවනවා
        $message = "Database Error: " . $e->getMessage();
        $message_class = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrainHub - Passenger Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .btn-primary { background-color: #2c3e50; border: none; }
        .btn-primary:hover { background-color: #1a252f; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h3 class="text-center mb-4">TrainHub Passenger Registration</h3>
                
                <?php if (!empty($message)): ?>
                    <div class="alert <?php echo $message_class; ?> text-center" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required placeholder="Enter your full name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Create a secure password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Register Account</button>
                </form>
                
                <div class="text-center mt-3">
                    <p>Already have an account? <a href="login.php" style="color: #2c3e50;">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>