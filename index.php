<?php
// ====================================================================
// PROJECT NAME: TrainHub Railway System
// FILE NAME: index.php
// DESCRIPTION: Original Beautiful Home Page (Fully English Translated)
// ====================================================================

// 1. Include Header
require_once 'includes/header.php';

// 2. Get Database Connection
require_once 'config/db.php';

// Fetch Stations for dropdown
try {
    $stations = $pdo->query("SELECT * FROM stations ORDER BY station_name ASC")->fetchAll();
} catch (\PDOException $e) {
    $stations = [];
}
?>

<div class="container my-5">
    <div class="row g-4 align-items-stretch">
        <div class="col-lg-5">
            <div class="card bg-secondary text-white border-0 p-4 shadow-lg h-100 rounded-3 d-flex flex-column justify-content-center">
                <h3 class="card-title fw-bold text-info mb-4">
                    <i class="fa fa-ticket-simple me-2"></i>Search Train Journeys
                </h3>
                
                <form action="search_trains.php" method="GET">
                    <div class="mb-3">
                        <label class="form-label text-light small fw-bold">Departure Station (From)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-white border-0"><i class="fa fa-train-subway"></i></span>
                            <select name="from" class="form-select bg-dark text-white border-0" required>
                                <option value="" disabled selected>Select Start Station</option>
                                <?php foreach ($stations as $station): ?>
                                    <option value="<?php echo $station['id']; ?>">
                                        <?php echo htmlspecialchars($station['station_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-light small fw-bold">Destination Station (To)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-white border-0"><i class="fa fa-location-dot"></i></span>
                            <select name="to" class="form-select bg-dark text-white border-0" required>
                                <option value="" disabled selected>Select Destination Station</option>
                                <?php foreach ($stations as $station): ?>
                                    <option value="<?php echo $station['id']; ?>">
                                        <?php echo htmlspecialchars($station['station_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-info w-100 fw-bold py-2 text-dark shadow-sm">
                        <i class="fa fa-search me-2"></i>Find Trains Now
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card bg-dark text-white p-5 shadow-lg border-0 rounded-3 h-100 d-flex flex-column justify-content-between" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <div>
                    <span class="badge bg-info text-dark mb-3 px-3 py-2 text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px;">Smart Railway Companion</span>
                    <h1 class="display-5 fw-bold text-white mb-3">Welcome to <span class="text-warning">TrainHub</span></h1>
                    <p class="text-white-50 lead mb-4">The official digital platform for searching Sri Lankan train schedules, real-time tracking, and booking seats with ease.</p>
                    
                    <div class="row g-3 mt-2">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center p-2 rounded bg-secondary bg-opacity-10 border border-secondary border-opacity-25">
                                <i class="fa fa-calendar-check text-warning fa-2x me-3"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold">Live Timetable</h6>
                                    <small class="text-white-50">Constantly updated</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center p-2 rounded bg-secondary bg-opacity-10 border border-secondary border-opacity-25">
                                <i class="fa fa-shield-halved text-success fa-2x me-3"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold">Secure Booking</h6>
                                    <small class="text-white-50">100% Trusted System</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>