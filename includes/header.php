<?php
// ====================================================================
// PROJECT NAME: TrainHub Railway System
// FILE NAME: includes/header.php
// DESCRIPTION: Dynamic Navigation Bar & Global Head Configuration
// ====================================================================

// 1. Session එක දැනටමත් ආරම්භ වී නොමැති නම් පමණක් ආරම්භ කිරීම
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrainHub - Sri Lanka Railways Companion</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa !important;
            color: #212529 !important;
        }
        .navbar-dark .nav-link {
            color: rgba(255, 255, 255, 0.75) !important;
            font-weight: 500;
        }
        .navbar-dark .nav-link:hover {
            color: #0dcaf0 !important;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-info fs-4" href="index.php">
            <i class="fa-solid fa-train-subway me-2"></i>TrainHub
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="schedules.php">Schedules</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="route_map.php">Route Map</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gallery.php">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About & History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link text-warning fw-bold border border-warning rounded px-3 py-1" href="admin/dashboard.php">
                                <i class="fa-solid fa-user-shield me-1"></i> Admin Panel
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link text-info fw-bold border border-info rounded px-3 py-1" href="dashboard.php">
                                <i class="fa-solid fa-user-circle me-1"></i> My Dashboard
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-sm btn-outline-danger px-3" href="logout.php">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                        </a>
                    </li>
                    
                <?php else: ?>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-sm btn-outline-info px-4 fw-bold shadow-sm" href="login.php">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                        </a>
                    </li>
                <?php endif; ?>
                
            </ul>
        </div>
    </div>
</nav>