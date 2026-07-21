<?php
// ඩමි දුම්රිය කාලසටහන් දත්ත සමුදාය
$schedules = [
    [
        'id' => 'SCH-101',
        'train_name' => 'Udarata Menike',
        'route' => 'Colombo Fort to Badulla',
        'dep_time' => '05:55 AM',
        'arr_time' => '03:45 PM',
        'type' => 'Express',
        'frequency' => 'Daily',
        'status' => 'Active'
    ],
    [
        'id' => 'SCH-102',
        'train_name' => 'Yal Devi',
        'route' => 'Colombo Fort to Jaffna',
        'dep_time' => '06:35 AM',
        'arr_time' => '01:15 PM',
        'type' => 'Express',
        'frequency' => 'Daily',
        'status' => 'Active'
    ],
    [
        'id' => 'SCH-103',
        'train_name' => 'Colombo Commuter',
        'route' => 'Maradana to Matara',
        'dep_time' => '03:40 PM',
        'arr_time' => '06:50 PM',
        'type' => 'Electricity / Local',
        'frequency' => 'Weekdays Only',
        'status' => 'Delayed'
    ]
];

$message = "";
if (isset($_POST['add_schedule'])) {
    $message = "New Train Schedule added successfully!";
}
if (isset($_GET['delete_id'])) {
    $message = "Schedule " . htmlspecialchars($_GET['delete_id']) . " deleted successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrainHub Admin - Manage Schedules</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            background-color: #1e293b; 
            color: #f8fafc; 
            font-family: 'Segoe UI', sans-serif; 
        }
        .admin-card { 
            background-color: #0f172a; 
            border-radius: 12px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.3); 
            border: 1px solid #334155; 
        }
        
        /* Form Input Styling */
        .form-control, .form-select {
            background-color: #1e293b !important;
            border: 1px solid #475569 !important;
            color: #ffffff !important;
        }
        .form-control::placeholder {
            color: #94a3b8 !important;
        }
        
        /* 📊 Table Text visibility Fixes (අකුරු තද කළු පාට කිරීම) */
        .table-custom {
            color: #000000 !important;
            border-color: #cbd5e1 !important;
        }
        .table-custom thead th {
            background-color: #334155 !important;
            color: #ffffff !important;
        }
        .table-custom td {
            color: #000000 !important;
            font-weight: 500;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f5f9 !important;
        }
        .text-primary-custom {
            color: #1d4ed8 !important;
        }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row">
        
        <div class="col-md-4 mb-4">
            <div class="card admin-card p-4">
                <h4 class="text-white mb-3"><i class="fa-solid fa-calendar-plus" style="color:#38bdf8;"></i> Add New Schedule</h4>
                <hr class="border-secondary">
                
                <form action="manage_schedules.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-white-50">Train Name</label>
                        <input type="text" class="form-control" name="train_name" placeholder="Enter Train Name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-white-50">Select Route</label>
                        <select class="form-select" name="route" required>
                            <option value="" selected disabled>-- Select Route --</option>
                            <option value="Colombo Fort to Badulla">Colombo Fort to Badulla</option>
                            <option value="Colombo Fort to Jaffna">Colombo Fort to Jaffna</option>
                            <option value="Maradana to Matara">Maradana to Matara</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-white-50">Train Type</label>
                        <select class="form-select" name="train_type" required>
                            <option value="Express">Express Train</option>
                            <option value="Electricity / Intercity">Electricity / Intercity</option>
                            <option value="Local / Commuter">Local / Commuter</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold text-white-50">Departure Time</label>
                            <input type="time" class="form-control" name="dep_time" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold text-white-50">Arrival Time</label>
                            <input type="time" class="form-control" name="arr_time" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-white-50">Frequency Type</label>
                        <select class="form-select" name="frequency">
                            <option value="Daily">Daily</option>
                            <option value="Weekdays">Weekdays Only</option>
                        </select>
                    </div>
                    
                    <button type="submit" name="add_schedule" class="btn btn-primary w-100 fw-bold mt-2" style="background-color: #38bdf8; border: none; color: #0f172a;">
                        <i class="fa-solid fa-plus"></i> Save Schedule
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card admin-card p-4 bg-white"> <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-3 border-secondary-subtle">
                    <h2 class="text-dark mb-0"><i class="fa-solid fa-calendar-days text-primary"></i> Train Schedules</h2>
                    <a href="dashboard.php" class="btn btn-outline-dark btn-sm fw-bold">
                        <i class="fa-solid fa-right-from-bracket"></i> Exit
                    </a>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-success text-center py-2 small" role="alert">
                        <i class="fa-solid fa-circle-check"></i> <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle table-custom bg-white">
                        <thead>
                            <tr class="text-white">
                                <th>ID</th>
                                <th>Train Name</th>
                                <th>Route</th>
                                <th>Type</th>
                                <th>Dep / Arr</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($schedules as $sch): ?>
                                <tr>
                                    <td class="fw-bold text-primary-custom"><?php echo $sch['id']; ?></td>
                                    <td class="text-dark fw-bold"><?php echo $sch['train_name']; ?></td>
                                    <td class="text-dark"><?php echo $sch['route']; ?></td>
                                    <td><span class="badge bg-dark border border-secondary"><?php echo $sch['type']; ?></span></td>
                                    <td>
                                        <span class="text-success fw-bold"><?php echo $sch['dep_time']; ?></span> ➡️ 
                                        <span class="text-danger fw-bold"><?php echo $sch['arr_time']; ?></span>
                                    </td>
                                    <td>
                                        <?php if($sch['status'] == 'Active'): ?>
                                            <span class="badge bg-success text-white px-2">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark px-2">Delayed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="manage_schedules.php?delete_id=<?php echo $sch['id']; ?>" class="btn btn-sm btn-outline-danger pt-0 pb-0 px-2">
                                            <i class="fa-solid fa-trash-can small"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>