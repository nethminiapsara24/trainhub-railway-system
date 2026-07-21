<?php
// ====================================================================
// PROJECT NAME: TrainHub Railway System
// FILE NAME: dashboard.php
// DESCRIPTION: Passenger Dashboard with Active QR Tickets Table (Fully Fixed)
// ====================================================================

// 1. Include Header
require_once 'includes/header.php';

// 2. Ensure Session is started and User is Logged In
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user session doesn't exist
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 3. Get Database Connection
require_once 'config/db.php';

$user_id = $_SESSION['user_id'];
$passenger_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "Dinitha Mihisara";
$account_type = "Passenger";

// ලොග් වී සිටින මගියාගේ බුකින් විස්තර ඩේටාබේස් එකෙන් ලබා ගැනීම
try {
    // කිසිදු වැරදීමක් සිදු නොවන සරලම SQL Query එක
    $query = "SELECT * FROM bookings WHERE user_id = ? ORDER BY id DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $my_bookings = $stmt->fetchAll();
} catch (\PDOException $e) {
    $my_bookings = [];
}
?>

<div class="container my-5">
    <div class="bg-dark text-white p-4 rounded-3 shadow-sm mb-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-left: 5px solid #00d2ff;">
        <h2 class="fw-bold mb-1 text-white">Welcome Back, <span class="text-info"><?php echo htmlspecialchars($passenger_name); ?></span></h2>
        <p class="text-white-50 small mb-0">Welcome to the TrainHub Passenger Control Panel. Manage your transits efficiently.</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card bg-secondary text-white border-0 p-4 shadow-lg h-100 rounded-3">
                <h4 class="card-title fw-bold text-info mb-4 border-bottom border-dark pb-2">
                    <i class="fa-solid fa-user-gear me-2"></i>My Account Details
                </h4>
                
                <div class="mb-3">
                    <label class="text-white-50 small d-block mb-1">Full Name</label>
                    <span class="fw-bold text-white fs-5"><?php echo htmlspecialchars($passenger_name); ?></span>
                </div>

                <div class="mb-3">
                    <label class="text-white-50 small d-block mb-1">Account Role</label>
                    <span class="badge bg-info text-dark fw-bold text-uppercase px-3 py-2" style="font-size: 11px;">
                        <i class="fa-solid fa-passport me-1"></i><?php echo $account_type; ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card bg-dark text-white p-4 shadow-lg border-0 rounded-3 h-100 d-flex flex-column justify-content-between">
                <div>
                    <h4 class="card-title fw-bold text-warning mb-3">
                        <i class="fa-solid fa-qrcode me-2"></i>Reservation Overview
                    </h4>
                    <p class="text-white-50 mb-0">
                        <i class="fa-solid fa-circle-info text-info me-2"></i> All your reserved digital QR tickets, journey references, and transit seat allocations can be viewed dynamically in the records section down below.
                    </p>
                </div>
                <div class="mt-3 bg-secondary bg-opacity-10 p-2 rounded text-center border border-secondary border-opacity-25 small text-muted">
                    <i class="fa-solid fa-mobile-screen-button me-2"></i>Present the digital QR code to the station master during platform boarding.
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-dark text-white p-4 shadow-lg border-0 rounded-3 mt-4">
        <h4 class="card-title fw-bold text-info mb-4">
            <i class="fa-solid fa-clipboard-list me-2"></i>My Booked QR Tickets
        </h4>

        <?php if (!empty($my_bookings) && count($my_bookings) > 0): ?>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle border-secondary">
                    <thead>
                        <tr class="text-info border-bottom border-secondary">
                            <th style="width: 150px;">QR Pass</th>
                            <th>Reference No</th>
                            <th>Class</th>
                            <th>Seat Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($my_bookings as $booking): ?>
                            <tr>
                                <td>
                                    <div class="bg-white p-2 rounded text-center d-inline-block shadow-sm">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=<?php echo urlencode($booking['booking_reference']); ?>" alt="QR Code" style="width: 70px; height: 70px;">
                                    </div>
                                </td>
                                <td class="fw-bold text-white fs-6"><?php echo htmlspecialchars($booking['booking_reference']); ?></td>
                                <td>
                                    <span class="badge bg-info text-dark text-uppercase fw-bold px-3 py-2"><?php echo htmlspecialchars($booking['ticket_class']); ?> Class</span>
                                </td>
                                <td class="text-warning fw-bold fs-6"><?php echo htmlspecialchars($booking['seat_number']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5 bg-secondary bg-opacity-10 rounded-3 border border-secondary border-opacity-25 my-2">
                <i class="fa-solid fa-folder-open display-4 text-muted mb-3 d-block"></i>
                <p class="text-white-50 mb-3">No active bookings found under your account reference.</p>
                <a href="index.php" class="btn btn-info fw-bold px-4 py-2 text-dark shadow-sm">
                    <i class="fa fa-search me-2"></i>Book a New Ticket Now
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php 
// 4. Include Footer
require_once 'includes/footer.php'; 
?>