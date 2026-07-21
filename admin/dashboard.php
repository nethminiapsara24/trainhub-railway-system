<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
require_once '../config/db.php';
try {
    $trains_count = $pdo->query("SELECT COUNT(*) FROM trains")->fetchColumn();
    $bookings_count = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
    $images_count = $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
} catch (\PDOException $e) {
    die("දත්ත ලබා ගැනීමට නොහැකි විය: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <title>TrainHub - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    /* 🎨 Premium Dark Slate Background */
    body { 
        background-color: #1e293b; 
        color: #f8fafc; 
        font-family: 'Segoe UI', sans-serif; 
    }
    
    /* 🏢 Dark Main Card Container */
    .admin-card { 
        background-color: #0f172a; 
        border-radius: 12px; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.3); 
        border: 1px solid #334155; 
        padding: 24px;
    }
    
    /* 📊 Dark Table Headers and Borders */
    .table-custom {
        color: #e2e8f0 !important;
        border-color: #334155 !important;
    }
    .table-custom thead {
        background-color: #334155 !important;
        color: #ffffff !important;
    }
    
    /* 🖱️ Table Row Hover Effect */
    .table-hover tbody tr:hover {
        background-color: #1e293b !important;
        color: #ffffff !important;
    }
    
    /* 🔗 Sidebar List Items Style (if applicable) */
    .list-group-item {
        background-color: #0f172a !important;
        color: #e2e8f0 !important;
        border: 1px solid #334155 !important;
    }
    .list-group-item:hover {
        background-color: #1e293b !important;
    }
    
    .text-primary-custom {
        color: #38bdf8 !important; /* Light Blue Accent */
    }
    
    /* 🖨️ PDF Print Optimization */
    @media print {
        body { background-color: #ffffff !important; color: #000000 !important; }
        .no-print { display: none !important; } 
        .card, .admin-card { box-shadow: none !important; border: none !important; padding: 0 !important; background: none !important; }
        .table { border: 1px solid #000 !important; width: 100% !important; color: #000 !important; }
        .table th { background-color: #f2f2f2 !important; color: #000 !important; font-weight: bold; }
    }
</style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-warning" href="dashboard.php"><i class="fa-solid fa-gauge-high me-2"></i>TrainHub Admin</a>
        <div class="ms-auto">
            <a href="../logout.php" class="btn btn-danger btn-sm fw-bold px-3"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
    </div>
</nav>
<div class="container my-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="list-group shadow-sm border-0">
                <a href="dashboard.php" class="list-group-item list-group-item-action active bg-dark border-dark fw-bold"><i class="fa fa-home me-2"></i>Dashboard Summary</a>
                <a href="manage_trains.php" class="list-group-item list-group-item-action text-dark"><i class="fa fa-train me-2 text-secondary"></i>Train Management</a>
                <a href="manage_schedules.php" class="list-group-item list-group-item-action text-dark"><i class="fa fa-calendar-alt me-2 text-secondary"></i>Schedule Management</a>
                <a href="view_bookings.php" class="list-group-item list-group-item-action text-dark"><i class="fa fa-ticket me-2 text-secondary"></i>Passengers Ticket List</a>
                <a href="admin_payments.php" class="list-group-item list-group-item-action text-dark">  <i class="fa-solid fa-money-check-dollar"></i> Payments</a>
                <a href="view_messages.php" class="list-group-item list-group-item-action text-dark"><i class="fa fa-envelope me-2 text-secondary"></i>Coustomer Messages</a>
                <a href="manage_gallery.php" class="list-group-item list-group-item-action text-dark"><i class="fa fa-image me-2 text-secondary"></i>Gallery Management</a>
                <a href="../index.php" target="_blank" class="list-group-item list-group-item-action text-primary fw-semibold"><i class="fa fa-globe me-2"></i>View Main Website</a>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row g-4 mb-5">
                <div class="col-md-4"><div class="card shadow-sm border-0 p-3 border-start border-4 border-primary"><h6 class="text-muted small fw-bold">Total Trains</h6><h3 class="fw-bold"><?php echo $trains_count; ?></h3></div></div>
                <div class="col-md-4"><div class="card shadow-sm border-0 p-3 border-start border-4 border-success"><h6 class="text-muted small fw-bold">Total Bookings</h6><h3 class="fw-bold"><?php echo $bookings_count; ?></h3></div></div>
                <div class="col-md-4"><div class="card shadow-sm border-0 p-3 border-start border-4 border-warning"><h6 class="text-muted small fw-bold">Gallery Images</h6><h3 class="fw-bold"><?php echo $images_count; ?></h3></div></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
