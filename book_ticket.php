<?php
// ====================================================================
// FILE NAME: book_ticket.php
// DESCRIPTION: Secure Ticket Booking & Confirmation Page (English UI)
// ====================================================================

if (session_status() == PHP_SESSION_NONE) { 
    session_start(); 
}

require_once 'includes/header.php';
require_once 'config/db.php';

// 1. පරිශීලකයා Login වී නැත්නම් Login පිටුවට හරවා යැවීම
if (!isset($_SESSION['user_id'])) {
    echo "<div class='container my-5'><div class='alert alert-warning text-center'>Please <a href='login.php'>Login</a> first to book tickets.</div></div>";
    require_once 'includes/footer.php';
    exit();
}

// URL එකෙන් එන දත්ත ලබා ගැනීම (GET Request)
$timetable_id = isset($_GET['timetable_id']) ? intval($_GET['timetable_id']) : 0;
$class = isset($_GET['class']) ? htmlspecialchars($_GET['class']) : '3rd';

$success_msg = "";
$error_msg = "";

// 2. පරිශීලකයා "Confirm Booking" බොත්තම එබූ විට ක්‍රියාත්මක වන කොටස (POST Request)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['process_booking'])) {
    $user_id = $_SESSION['user_id'];
    $t_id = intval($_POST['timetable_id']);
    $t_class = htmlspecialchars($_POST['ticket_class']);
    $booking_ref = "TB" . strtoupper(uniqid());
    $seat_no = "A-" . rand(1, 60);

    try {
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, timetable_id, booking_reference, seat_number, ticket_class) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $t_id, $booking_ref, $seat_no, $t_class]);
        
        $success_msg = "Ticket booked successfully! Reference: <strong>$booking_ref</strong> (Seat: $seat_no)";
    } catch (\PDOException $e) {
        $error_msg = "Booking failed! Database Error: " . $e->getMessage();
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-white p-4 shadow-lg border-0 rounded-3">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-ticket display-4 text-info mb-2"></i>
                    <h3 class="fw-bold">Confirm Your Ticket</h3>
                    <p class="text-white-50 small">Please review your booking details before confirmation</p>
                </div>

                <?php if (!empty($success_msg)): ?>
                    <div class="alert alert-success py-2 small"><?php echo $success_msg; ?></div>
                <?php endif; ?>
                <?php if (!empty($error_msg)): ?>
                    <div class="alert alert-danger py-2 small"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <form action="payment.php?timetable_id=<?php echo $timetable_id; ?>&class=<?php echo $class; ?>" method="POST">
                    <input type="hidden" name="timetable_id" value="<?php echo $timetable_id; ?>">
                    <input type="hidden" name="ticket_class" value="<?php echo $class; ?>">

                    <div class="bg-secondary bg-opacity-25 p-3 rounded-3 mb-4 border border-secondary">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-white-50">Timetable ID:</span>
                            <span class="fw-bold text-white">#<?php echo $timetable_id; ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-white-50">Selected Class:</span>
                            <span class="badge bg-info text-dark fw-bold text-uppercase"><?php echo $class; ?> Class</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-white-50">Passenger ID:</span>
                            <span class="fw-bold text-white">#<?php echo $_SESSION['user_id']; ?></span>
                        </div>
                    </div>

                    <?php if (empty($success_msg)): ?>
                        <button type="submit" name="process_booking" class="btn btn-info w-100 fw-bold py-2 text-dark shadow-sm">
                            <i class="fa fa-check-circle me-2"></i>Confirm & Book Now
                        </button>
                    <?php else: ?>
                        <a href="index.php" class="btn btn-secondary w-100 fw-bold py-2">Go to Home</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
require_once 'includes/footer.php'; 
?>