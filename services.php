<?php
// ====================================================================
// PROJECT NAME: TrainHub Railway System
// FILE NAME: services.php
// DESCRIPTION: 100% English Standardized Services Directory
// ====================================================================

// 1. Include Header
require_once 'includes/header.php';
?>

<div class="container my-5">
    <!-- Main Heading Section -->
    <div class="text-center mb-5">
        <span class="badge bg-warning text-dark mb-2 px-3 py-2 text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px;">TrainHub Digital Solutions</span>
        <h1 class="fw-bold text-dark display-5">Our Services</h1>
        <p class="text-muted max-w-2xl mx-auto">Discover the modern, secure, and smart digital railway solutions designed efficiently for Sri Lankan railway commuters.</p>
    </div>

    <!-- Services Grid Layout -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 text-center">
        
        <!-- SERVICE 1: Online Ticket Booking -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-3 bg-white transition-all hover-up">
                <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle mx-auto d-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-ticket fs-3"></i>
                </div>
                <h5 class="fw-bold text-dark mb-3">Online Ticket Booking</h5>
                <p class="text-muted small mb-0">Skip the long station queues. Book your train tickets instantly online and receive your secure digital passenger pass right on your personal dashboard.</p>
            </div>
        </div>

        <!-- SERVICE 2: Seat Reservation -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-3 bg-white transition-all hover-up">
                <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle mx-auto d-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-chair fs-3"></i>
                </div>
                <h5 class="fw-bold text-dark mb-3">Seat Reservation</h5>
                <p class="text-muted small mb-0">Choose and reserve your preferred seats across 1st Class Observation, 2nd Class, and 3rd Class compartments ahead of time for a comfortable, guaranteed journey.</p>
            </div>
        </div>

        <!-- SERVICE 3: Route Management -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-3 bg-white transition-all hover-up">
                <div class="icon-box bg-info bg-opacity-10 text-info rounded-circle mx-auto d-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-map-location-dot fs-3"></i>
                </div>
                <h5 class="fw-bold text-dark mb-3">Route Management</h5>
                <p class="text-muted small mb-0">Explore and analyze all major railway routes in Sri Lanka. Track inter-station travel distances, connections, and navigation metrics accurately through our system.</p>
            </div>
        </div>

        <!-- SERVICE 4: Train Scheduling -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-3 bg-white transition-all hover-up">
                <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle mx-auto d-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-calendar-days fs-3"></i>
                </div>
                <h5 class="fw-bold text-dark mb-3">Train Scheduling</h5>
                <p class="text-muted small mb-0">Access daily, updated timetables for express, intercity, and night mail trains. View arrival times, departures, delays, and stopover details dynamically.</p>
            </div>
        </div>

    </div>
</div>

<!-- Custom Hover Styling -->
<style>
    .hover-up {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-up:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }
</style>

<?php 
// 3. Include Footer
require_once 'includes/footer.php'; 
?>