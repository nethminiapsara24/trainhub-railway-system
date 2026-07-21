<?php
// ඩමි දත්ත සමුදාය
$payments = [
    [
        'id' => 'PAY-001',
        'passenger' => 'Dinitha Mihisara',
        'method' => 'Visa Card',
        'amount' => 'LKR 1,500.00',
        'date' => '2026-07-13',
        'status' => 'Success'
    ],
    [
        'id' => 'PAY-002',
        'passenger' => 'Nethmini Apsara',
        'method' => 'eZ Cash',
        'amount' => 'LKR 850.00',
        'date' => '2026-07-13',
        'status' => 'Success'
    ],
    [
        'id' => 'PAY-003',
        'passenger' => 'Mahesh Silva',
        'method' => 'Bank Transfer',
        'amount' => 'LKR 2,300.00',
        'date' => '2026-07-12',
        'status' => 'Pending Approval'
    ]
];

// Approve බටන් එක එබූ විට Status එක වෙනස් කිරීම
$message = "";
if (isset($_GET['approve_id'])) {
    $message = "Payment " . htmlspecialchars($_GET['approve_id']) . " has been Approved successfully!";
    if ($_GET['approve_id'] == 'PAY-003') {
        $payments[2]['status'] = 'Success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrainHub Admin - Payment Management</title>
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
        
        /* 📊 Table Text Visibility Fixes (අකුරු තද කළු පාට කිරීම) */
        .table-custom {
            color: #000000 !important;
            border-color: #cbd5e1 !important;
        }
        .table-custom thead th {
            background-color: #334155 !important;
            color: #ffffff !important;
        }
        .table-custom td {
            color: #000000 !important; /* Table දත්ත කළු කරයි */
            font-weight: 550;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f5f9 !important;
        }
        .text-primary-custom {
            color: #1d4ed8 !important; /* Transaction ID තද නිල් පාට */
        }
        
        @media print {
            body { background-color: #ffffff !important; color: #000000 !important; }
            .no-print { display: none !important; } 
            .card { box-shadow: none !important; border: none !important; padding: 0 !important; background: none !important; }
            .table { border: 1px solid #000 !important; width: 100% !important; color: #000 !important; }
            .table th { background-color: #f2f2f2 !important; color: #000 !important; font-weight: bold; }
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card admin-card p-4 bg-white"> <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3 border-secondary-subtle">
                    <h2 class="text-dark mb-0"><i class="fa-solid fa-money-check-dollar text-primary"></i> Passenger Payments Management</h2>
                    
                    <div class="no-print">
                        <button onclick="window.print();" class="btn btn-success fw-bold me-2">
                            <i class="fa-solid fa-file-pdf"></i> Download PDF Report
                        </button>
                        
                        <button type="button" onclick="window.location.href='dashboard.php';" class="btn btn-outline-dark fw-bold">
                            <i class="fa-solid fa-right-from-bracket"></i> Exit to Dashboard
                        </button>
                    </div>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-success text-center no-print" role="alert">
                        <i class="fa-solid fa-circle-check"></i> <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle table-custom bg-white">
                        <thead>
                            <tr class="text-white">
                                <th>Transaction ID</th>
                                <th>Passenger Name</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Status</th>
                                <th class="text-center no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payments as $pay): ?>
                                <tr>
                                    <td class="fw-bold text-primary-custom"><?php echo $pay['id']; ?></td>
                                    <td class="text-dark"><?php echo $pay['passenger']; ?></td>
                                    <td class="text-dark">
                                        <?php if($pay['method'] == 'Visa Card'): ?>
                                            <i class="fa-brands fa-cc-visa text-primary me-1"></i>
                                        <?php elseif($pay['method'] == 'eZ Cash'): ?>
                                            <i class="fa-solid fa-mobile-screen text-success me-1"></i>
                                        <?php else: ?>
                                            <i class="fa-solid fa-building-columns text-warning me-1"></i>
                                        <?php endif; ?>
                                        <?php echo $pay['method']; ?>
                                    </td>
                                    <td class="text-danger fw-bold"><?php echo $pay['amount']; ?></td>
                                    <td class="text-dark"><?php echo $pay['date']; ?></td>
                                    <td>
                                        <?php if($pay['status'] == 'Success'): ?>
                                            <span class="badge bg-success text-white px-2"><i class="fa-solid fa-check"></i> Paid</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark px-2"><i class="fa-solid fa-clock"></i> Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center no-print">
                                        <?php if($pay['status'] == 'Pending Approval'): ?>
                                            <a href="admin_payments.php?approve_id=<?php echo $pay['id']; ?>" class="btn btn-sm btn-success fw-bold me-1">
                                                Approve
                                            </a>
                                        <?php else: ?>
                                            <span class="text-success fw-bold small"><i class="fa-solid fa-circle-check"></i> Verified</span>
                                        <?php endif; ?>
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