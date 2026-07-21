<?php
// 1. ඩේටාබේස් සහ හෙඩර් සම්බන්ධ කිරීම
require_once 'config/db.php';
include_once 'includes/header.php';

// 2. URL එක හරහා ලැබෙන දත්ත ලබා ගැනීම (GET Method)
$from_station = isset($_GET['from']) ? intval($_GET['from']) : 0;
$to_station = isset($_GET['to']) ? intval($_GET['to']) : 0;
$travel_date = isset($_GET['date']) ? $_GET['date'] : '';
$class_type = isset($_GET['class']) ? $_GET['class'] : '3rd';

$results = [];

// 3. මගියා තෝරාගත් ස්ථාන දෙකම පද්ධතියේ පවතී නම් පමණක් ඩේටාබේස් එක සෙවීම
if ($from_station > 0 && $to_station > 0) {
    try {
        // මගියා තෝරාගත් ආරම්භක සහ ගමනාන්ත ස්ථාන වලට ගැළපෙන ධාවන කාලසටහන් සොයන SQL Query එක
        $query = "SELECT 
                    t.train_number, 
                    t.train_name, 
                    t.train_type,
                    r.route_name,
                    tt.id AS timetable_id,
                    tt.departure_time, 
                    tt.arrival_time, 
                    tt.available_seats, 
                    tt.status
                  FROM timetable tt
                  JOIN trains t ON tt.train_id = t.id
                  JOIN routes r ON tt.route_id = r.id
                  WHERE r.start_station_id = ? AND r.end_station_id = ?";
                  
        $stmt = $pdo->prepare($query);
        $stmt->execute([$from_station, $to_station]);
        $results = $stmt->fetchAll();
    } catch (\PDOException $e) {
        die("දත්ත සෙවීමේදී ගැටලුවක් ඇතිවිය: " . $e->getMessage());
    }
}
?>

<div class="container my-5">
    
    <div class="mb-4">
        <h3 class="fw-bold text-dark"><i class="fa fa-train text-info me-2"></i>ලබාගත හැකි දුම්රියන් (Available Trains)</h3>
        <p class="text-muted small">ඔබ තෝරාගත් දිනට සහ ගමන් මාර්ගයට ගැළපෙන ශ්‍රී ලංකා දුම්රිය ලැයිස්තුව පහතින් දැක්වේ.</p>
        <?php if (!empty($travel_date)): ?>
            <span class="badge bg-dark text-info p-2"><i class="fa fa-calendar me-1"></i> ගමන් දිනය: <?php echo htmlspecialchars($travel_date); ?></span>
            <span class="badge bg-secondary p-2"><i class="fa fa-users me-1"></i> පන්තිය: <?php echo htmlspecialchars($class_type); ?> Class</span>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">Train No</th>
                            <th>Train Name</th>
                            <th>Departure -> Arrival</th>
                            <th class="text-center">Available Seats</th>
                            <th>Status</th>
                            <th class="pe-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($results) > 0): ?>
                            <?php foreach ($results as $row): ?>
                                <tr>
                                    <td class="ps-3 fw-bold text-secondary">#<?php echo htmlspecialchars($row['train_number']); ?></td>
                                    
                                    <td>
                                        <span class="fw-bold text-dark d-block"><?php echo htmlspecialchars($row['train_name']); ?></span>
                                        <small class="text-muted"><?php echo htmlspecialchars($row['train_type']); ?></small>
                                    </td>
                                    
                                    <td>
                                        <span class="text-success fw-bold"><?php echo date("g:i A", strtotime($row['departure_time'])); ?></span>
                                        <i class="fa-solid fa-arrow-right mx-2 text-muted small"></i>
                                        <span class="text-primary fw-bold"><?php echo date("g:i A", strtotime($row['arrival_time'])); ?></span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="badge bg-info-subtle text-info-emphasis px-3 py-2 fw-bold">
                                            <?php echo htmlspecialchars($row['available_seats']); ?> Seats
                                        </span>
                                    </td>
                                    
                                    <td>
                                        <?php if ($row['status'] == 'Scheduled'): ?>
                                            <span class="badge bg-success">On Time</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark"><?php echo htmlspecialchars($row['status']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="pe-3 text-center">
                                        <a href="book_ticket.php?timetable_id=<?php echo $row['timetable_id']; ?>&date=<?php echo urlencode($travel_date); ?>&class=<?php echo urlencode($class_type); ?>" class="btn btn-info btn-sm fw-bold text-dark px-3 shadow-sm">
                                            <i class="fa fa-shopping-cart me-1"></i> Book Now
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-train-slash display-4 d-block mb-3 text-secondary"></i>
                                    කණගාටුයි! ඔබ තෝරාගත් ගමන් මාර්ගය සඳහා දුම්රියක් සොයා ගැනීමට නොහැකි විය. <br>
                                    <a href="index.php" class="btn btn-sm btn-outline-dark mt-3">නැවත සොයන්න</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php 
// 4. ෆුටර් එක සම්බන්ධ කිරීම
include_once 'includes/footer.php'; 
?>