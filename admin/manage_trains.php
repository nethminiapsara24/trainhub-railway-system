<?php
// සෙෂන් එක ආරම්භ කරමු (ඩේටා ටික තාවකාලිකව මතකයේ තබා ගැනීමට)
session_start();

// සෙෂන් එකේ දුම්රිය දත්ත නැත්නම් මුල් දත්ත ටික ඇතුළත් කරමු
if (!isset($_SESSION['trains'])) {
    $_SESSION['trains'] = [
        [
            'id' => 'TRN-001',
            'name' => 'Udarata Menike',
            'number' => '1015',
            'type' => 'Express',
            'capacity' => '450 Seats',
            'status' => 'Available'
        ],
        [
            'id' => 'TRN-002',
            'name' => 'Yal Devi',
            'number' => '4001',
            'type' => 'Express',
            'capacity' => '500 Seats',
            'status' => 'Available'
        ],
        [
            'id' => 'TRN-003',
            'name' => 'Galu Kumari',
            'number' => '8056',
            'type' => 'Local / Commuter',
            'capacity' => '600 Seats',
            'status' => 'Under Maintenance'
        ]
    ];
}

$message = "";

// 🛠️ 1. Form එක Submit වූ විට ක්‍රියාත්මක වන කොටස (Add Train)
if (isset($_POST['add_train'])) {
    $train_name = trim($_POST['train_name']);
    $train_number = trim($_POST['train_number']);
    $train_type = trim($_POST['train_type']);
    $capacity = trim($_POST['capacity']) . " Seats";
    
    // අලුත් ID එකක් සාදා ගැනීම (උදා: TRN-004)
    $next_id = "TRN-00" . (count($_SESSION['trains']) + 1);
    
    // අලුත් ඩේටා ටික Array එකට එකතු කිරීම
    $_SESSION['trains'][] = [
        'id' => $next_id,
        'name' => $train_name,
        'number' => $train_number,
        'type' => $train_type,
        'capacity' => $capacity,
        'status' => 'Available'
    ];
    
    $message = "New Train '$train_name' added successfully to the Active Fleet!";
}

// 🛠️ 2. Delete බටන් එක එබූ විට ක්‍රියාත්මක වන කොටස
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    foreach ($_SESSION['trains'] as $key => $trn) {
        if ($trn['id'] == $delete_id) {
            unset($_SESSION['trains'][$key]);
            $message = "Train $delete_id removed successfully!";
            break;
        }
    }
    // Array එකේ Index පිළිවෙළ නැවත සකස් කිරීම
    $_SESSION['trains'] = array_values($_SESSION['trains']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrainHub Admin - Manage Trains</title>
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
        .form-control, .form-select {
            background-color: #1e293b !important;
            border: 1px solid #475569 !important;
            color: #ffffff !important;
        }
        .form-control::placeholder {
            color: #94a3b8 !important;
        }
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
                <h4 class="text-white mb-3"><i class="fa-solid fa-train-subway" style="color:#38bdf8;"></i> Add New Train</h4>
                <hr class="border-secondary">
                
                <form action="manage_trains.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-white-50">Train Name</label>
                        <input type="text" class="form-control" name="train_name" placeholder="e.g. Tikiri Menike" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-white-50">Train Number / Code</label>
                        <input type="text" class="form-control" name="train_number" placeholder="e.g. 1023" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-white-50">Train Type</label>
                        <select class="form-select" name="train_type" required>
                            <option value="Express">Express Train</option>
                            <option value="Electricity / Intercity">Electricity / Intercity</option>
                            <option value="Local / Commuter">Local / Commuter</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-white-50">Total Passenger Capacity</label>
                        <input type="number" class="form-control" name="capacity" placeholder="e.g. 500" required>
                    </div>
                    
                    <button type="submit" name="add_train" class="btn btn-primary w-100 fw-bold mt-2" style="background-color: #38bdf8; border: none; color: #0f172a;">
                        <i class="fa-solid fa-plus"></i> Save Train
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card admin-card p-4 bg-white">
                
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-3 border-secondary-subtle">
                    <h2 class="text-dark mb-0"><i class="fa-solid fa-list text-primary"></i> Active Fleet</h2>
                    <a href="dashboard.php" class="btn btn-outline-dark btn-sm fw-bold">
                         </a>

                    <button type="button" onclick="window.location.href='dashboard.php';" class="btn btn-outline-dark btn-sm fw-bold">
                         <i class="fa-solid fa-right-from-bracket"></i> Exit
                    </button>
                   
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
                                <th>Number</th>
                                <th>Type</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['trains'] as $trn): ?>
                                <tr>
                                    <td class="fw-bold text-primary-custom"><?php echo $trn['id']; ?></td>
                                    <td class="text-dark fw-bold"><?php echo $trn['name']; ?></td>
                                    <td class="text-dark"><?php echo $trn['number']; ?></td>
                                    <td><span class="badge bg-dark border border-secondary"><?php echo $trn['type']; ?></span></td>
                                    <td class="text-dark"><?php echo $trn['capacity']; ?></td>
                                    <td>
                                        <?php if($trn['status'] == 'Available'): ?>
                                            <span class="badge bg-success text-white px-2">Available</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger text-white px-2">Maintenance</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="manage_trains.php?delete_id=<?php echo $trn['id']; ?>" class="btn btn-sm btn-outline-danger pt-0 pb-0 px-2">
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