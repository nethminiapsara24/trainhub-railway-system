<?php
// 1. ඩේටාබේස් කනෙක්ෂන් එක සහ හෙඩර් එක සම්බන්ධ කිරීම
require_once 'config/db.php';
include_once 'includes/header.php';

// 2. SQL Query එක මඟින් දුම්රිය, මාර්ග සහ කාලසටහන් දත්ත එකට එකතු කර ලබා ගැනීම (JOIN Query)
try {
    $query = "SELECT 
                t.train_number, 
                t.train_name, 
                t.train_type,
                r.route_name,
                s1.station_name AS start_station,
                s2.station_name AS end_station,
                tt.departure_time, 
                tt.arrival_time, 
                tt.available_seats, 
                tt.status
              FROM timetable tt
              JOIN trains t ON tt.train_id = t.id
              JOIN routes r ON tt.route_id = r.id
              JOIN stations s1 ON r.start_station_id = s1.id
              JOIN stations s2 ON r.end_station_id = s2.id
              ORDER BY tt.departure_time ASC";
              
    $stmt = $pdo->query($query);
    $schedules = $stmt->fetchAll();
} catch (\PDOException $e) {
    die("කාලසටහන් දත්ත ලබා ගැනීමට නොහැකි විය: " . $e->getMessage());
}
?>

<div class="container my-5">
    
    <div class="text-center mb-5">
        <span class="badge bg-info text-dark mb-2 fw-bold px-3 py-2 text-uppercase">Sri Lanka Railways Timetable</span>
        <h2 class="fw-bold text-dark">දුම්රිය ධාවන කාලසටහන (Train Time Table)</h2>
        <p class="text-muted">ශ්‍රී ලංකාවේ ප්‍රධාන මාර්ගවල ධාවනය වන සියලුම විශේෂ සහ සීඝ්‍රගාමී දුම්රියන්ගේ වේලාවන් මෙතැනින් පරීක්ෂා කරන්න.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">Train No</th>
                            <th>Train Name</th>
                            <th>Route / Line</th>
                            <th>Departure Station</th>
                            <th>Destination</th>
                            <th>Dep. Time</th>
                            <th>Arr. Time</th>
                            <th class="text-center">Available Seats</th>
                            <th>Status</th>
                            <th class="pe-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($schedules) > 0): ?>
                            <?php foreach ($schedules as $row): ?>
                                <tr>
                                    <td class="ps-3 fw-bold text-secondary">#<?php echo htmlspecialchars($row['train_number']); ?></td>
                                    
                                    <td>
                                        <span class="fw-bold text-dark d-block"><?php echo htmlspecialchars($row['train_name']); ?></span>
                                        <small class="badge bg-light text-dark border border-secondary-subtle"><?php echo htmlspecialchars($row['train_type']); ?></small>
                                    </td>
                                    
                                    <td class="small text-muted"><?php echo htmlspecialchars($row['route_name']); ?></td>
                                    
                                    <td class="fw-semibold"><i class="fa-solid fa-circle-dot text-success me-1 small"></i> <?php echo htmlspecialchars($row['start_station']); ?></td>
                                    
                                    <td class="fw-semibold"><i class="fa-solid fa-location-dot text-danger me-1 small"></i> <?php echo htmlspecialchars($row['end_station']); ?></td>
                                    
                                    <td class="text-success fw-bold"><?php echo date("g:i A", strtotime($row['departure_time'])); ?></td>
                                    
                                    <td class="text-primary fw-bold"><?php echo date("g:i A", strtotime($row['arrival_time'])); ?></td>
                                    
                                    <td class="text-center">
                                        <span class="badge bg-info-subtle text-info-emphasis px-3 py-2 fw-bold">
                                            <?php echo htmlspecialchars($row['available_seats']); ?> Seats
                                        </span>
                                    </td>
                                    
                                    <td>
                                        <?php 
                                        if ($row['status'] == 'Scheduled') {
                                            echo '<span class="badge bg-success"><i class="fa fa-check-circle me-1"></i> Active</span>';
                                        } else if ($row['status'] == 'Delayed') {
                                            echo '<span class="badge bg-warning text-dark"><i class="fa fa-clock me-1"></i> Delayed</span>';
                                        } else {
                                            echo '<span class="badge bg-danger"><i class="fa fa-times-circle me-1"></i> Cancelled</span>';
                                        }
                                        ?>
                                    </td>
                                    
                                    <td class="pe-3 text-center">
                                        <a href="index.php" class="btn btn-dark btn-sm fw-bold text-info shadow-sm">
                                            <i class="fa fa-shopping-cart me-1"></i> Book
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">දැනට ධාවන කාලසටහන් කිසිවක් ඇතුළත් කර නැත.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php 
// 3. ෆුටර් එක සම්බන්ධ කිරීම
include_once 'includes/footer.php'; 
?>