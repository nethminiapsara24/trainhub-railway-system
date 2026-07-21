<?php
// ====================================================================
// PROJECT NAME: TrainHub Railway System
// FILE NAME: about.php
// DESCRIPTION: About Us & History Page (Fully English Translated)
// ====================================================================

// 1. Include Header
require_once 'includes/header.php';
?>

<div class="container my-5">
    <div class="text-center mb-5">
        <span class="badge bg-info text-dark mb-2 px-3 py-2 text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px;">Our Story</span>
        <h1 class="fw-bold text-dark">About TrainHub & Railway History</h1>
        <p class="text-muted">Discover our journey and the rich heritage of Sri Lankan Railways</p>
    </div>

    <div class="row g-4 align-items-stretch">
        <div class="col-lg-6">
            <div class="card bg-secondary text-white border-0 p-4 shadow-lg h-100 rounded-3 d-flex flex-column justify-content-between">
                <div>
                    <h3 class="card-title fw-bold text-info mb-4">
                        <i class="fa-solid fa-circle-info me-2"></i>About TrainHub
                    </h3>
                    <p class="lead text-white-50">TrainHub is a modern digital ecosystem designed to revolutionize how passengers interact with the Sri Lankan railway network.</p>
                    
                    <p class="small">Our platform bridges the gap between traditional railway operations and modern passenger convenience. By utilizing smart web technologies, we provide passengers with instant access to dynamic timetables, secure electronic ticketing, and a comprehensive digital visualization of available railway routes across the island.</p>
                    
                    <h5 class="fw-bold text-white mt-4 mb-3"><i class="fa fa-bullseye text-warning me-2"></i>Key Features</h5>
                    <ul class="list-unstyled small ps-2">
                        <li class="mb-2"><i class="fa fa-check text-info me-2"></i><strong>Instant Schedule Lookups:</strong> Find train times between any two interconnected stations instantly.</li>
                        <li class="mb-2"><i class="fa fa-check text-info me-2"></i><strong>Interactive Route Map:</strong> Visualize major rail tracks (Main, Coast, and Northern lines) dynamically.</li>
                        <li class="mb-2"><i class="fa fa-check text-info me-2"></i><strong>Secure Pass Management:</strong> Keep track of booked passenger references and carriage seat allocations safely.</li>
                    </ul>
                </div>

                <div class="mt-4 pt-3 border-top border-secondary text-white-50 small">
                    <p class="m-0"><i class="fa fa-heart text-danger me-2"></i>Dedicated to enhancing public transportation efficiency in Sri Lanka.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card bg-dark text-white p-4 shadow-lg border-0 rounded-3 h-100 d-flex flex-column justify-content-between" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <div>
                    <h3 class="card-title fw-bold text-warning mb-4">
                        <i class="fa-solid fa-clock-rotate-left me-2"></i>Historical Heritage
                    </h3>
                    <p class="text-white-50 mb-3">The history of railways in Sri Lanka (formerly Ceylon) dates back to the British colonial era, beginning a spectacular chapter in island transportation.</p>
                    
                    <div class="border-start border-secondary ps-3 my-3 small">
                        <div class="mb-3 position-relative">
                            <span class="position-absolute bg-info rounded-circle" style="width: 10px; height: 10px; left: -21px; top: 5px;"></span>
                            <strong class="text-info d-block">1858 - The Foundation</strong>
                            <p class="m-0 text-white-50">Construction officially commenced under the British government to transport coffee from the hill country to the port of Colombo.</p>
                        </div>
                        <div class="mb-3 position-relative">
                            <span class="position-absolute bg-warning rounded-circle" style="width: 10px; height: 10px; left: -21px; top: 5px;"></span>
                            <strong class="text-warning d-block">1864 - The First Train</strong>
                            <p class="m-0 text-white-50">The very first train engine steamed out from Colombo Fort to Ambepussa, marking the official birth of Ceylon Government Railway (CGR).</p>
                        </div>
                        <div class="position-relative">
                            <span class="position-absolute bg-success rounded-circle" style="width: 10px; height: 10px; left: -21px; top: 5px;"></span>
                            <strong class="text-success d-block">1924 - Expanding the Network</strong>
                            <p class="m-0 text-white-50">Tracks were successfully extended across stunning mountain passes to Badulla, creating one of the most scenic alpine railways in the world.</p>
                        </div>
                    </div>

                    <p class="small text-white-50 mt-2">Today, this legendary infrastructure continues to serve as the backbone of the nation's logistics, carrying millions of commuters and global travelers through pristine coastal fringes and breathtaking misty tea plantations.</p>
                </div>

                <div class="mt-4 pt-3 border-top border-secondary text-white-50 small">
                    <p class="m-0"><i class="fa-solid fa-train me-2 text-info"></i>Preserving history while driving toward a modernized digital future.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// 2. Include Footer
require_once 'includes/footer.php'; 
?>