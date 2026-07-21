<?php
// 1. ඩේටාබේස් කනෙක්ෂන් එක සහ හෙඩර් එක සම්බන්ධ කිරීම
require_once 'config/db.php';
include_once 'includes/header.php';

$success_msg = "";
$error_msg = "";

// 2. පාරිභෝගිකයා පණිවිඩය Submit කළ පසු ක්‍රියාත්මක වන කොටස
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    try {
        // contact_messages table එකට දත්ත ඇතුළත් කිරීමේ Query එක
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $message]);
        
        $success_msg = "ඔබගේ පණිවිඩය සාර්ථකව ඇඩ්මින් වෙත යොමු කරන ලදී. ස්තූතියි!";
    } catch (\PDOException $e) {
        $error_msg = "පණිවිඩය යැවීමට නොහැකි විය. නැවත උත්සාහ කරන්න: " . $e->getMessage();
    }
}
?>

<div class="bg-dark text-light py-5" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8));">
    <div class="container text-center py-3">
        <span class="badge bg-info text-dark mb-2 fw-bold px-3 py-2 text-uppercase">Get In Touch</span>
        <h2 class="fw-bold display-5">අප හා සම්බන්ධ වන්න</h2>
        <p class="lead text-secondary">TrainHub පද්ධතිය පිළිබඳ ඕනෑම ගැටලුවක් හෝ සහයෝගයක් සඳහා අප වෙත පණිවිඩයක් එවන්න.</p>
    </div>
</div>

<div class="container my-5">
    <div class="row g-5">
        
        <div class="col-lg-7">
            <div class="card shadow border-0 p-4 bg-white">
                <h4 class="fw-bold text-dark mb-4"><i class="fa-solid fa-paper-plane text-info me-2"></i>පණිවිඩයක් යොමු කරන්න</h4>
                
                <?php if(!empty($success_msg)): ?>
                    <div class="alert alert-success"><?php echo $success_msg; ?></div>
                <?php endif; ?>
                <?php if(!empty($error_msg)): ?>
                    <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <form action="contact.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">ඔබගේ නම (Your Name)</label>
                            <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-secondary">ඊමේල් ලිපිනය (Email Address)</label>
                            <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">මාතෘකාව (Subject)</label>
                        <input type="text" name="subject" class="form-control" placeholder="ටිකට් පත් වෙන්කිරීමේ ගැටලුවක්" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">පණිවිඩය (Message)</label>
                        <textarea name="message" class="form-control" rows="5" placeholder="ඔබේ ගැටලුව මෙතැන පැහැදිලිව ලියන්න..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-info w-100 fw-bold text-dark py-2 shadow-sm">Send Message</button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow border-0 p-4 bg-dark text-light h-100 d-flex flex-column justify-content-between">
                <div>
                    <h4 class="fw-bold text-info mb-4"><i class="fa-solid fa-address-book me-2"></i>පාරිභෝගික සහය සේවාව</h4>
                    <p class="small text-secondary mb-4">ශ්‍රී ලංකා දුම්රිය මගීන් වෙනුවෙන් ක්‍රියාත්මක පැය 24 පුරා ක්‍රියාත්මක නිල TrainHub සහය කාර්යාලය.</p>
                    
                    <div class="mb-3 d-flex align-items-center">
                        <div class="icon-box bg-secondary rounded p-2 text-center text-info me-3" style="width: 40px;"><i class="fa fa-map-marker-alt"></i></div>
                        <div><small class="text-secondary d-block">ලිපිනය</small><span class="fw-bold small">Railway Head Office, Colombo Fort, Sri Lanka</span></div>
                    </div>
                    
                    <div class="mb-3 d-flex align-items-center">
                        <div class="icon-box bg-secondary rounded p-2 text-center text-info me-3" style="width: 40px;"><i class="fa fa-phone"></i></div>
                        <div><small class="text-secondary d-block">දුරකථන අංකය</small><span class="fw-bold small">+94 11 234 5678 / +94 11 876 5432</span></div>
                    </div>
                    
                    <div class="mb-4 d-flex align-items-center">
                        <div class="icon-box bg-secondary rounded p-2 text-center text-info me-3" style="width: 40px;"><i class="fa fa-envelope"></i></div>
                        <div><small class="text-secondary d-block">ඊමේල් ලිපිනය</small><span class="fw-bold small">support@trainhub.lk</span></div>
                    </div>
                </div>

                <div class="rounded overflow-hidden border border-secondary mt-3" style="height: 180px; background: #333; position: relative;">
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-secondary bg-black bg-opacity-25">
                        <div class="text-center">
                            <i class="fa-solid fa-location-crosshairs text-info display-6 mb-2"></i>
                            <span class="d-block small text-muted">Colombo Fort Station Map Locator</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php 
// 3. ෆුටර් එක සම්බන්ධ කිරීම
include_once 'includes/footer.php'; 
?>