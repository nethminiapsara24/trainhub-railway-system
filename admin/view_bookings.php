<?php
// ඩමි මගී ටිකට් දත්ත සමුදාය
$tickets = [
    [
        'ticket_no' => 'TKT-9854',
        'passenger' => 'Dinitha Mihisara',
        'train' => 'Udarata Menike (1015)',
        'from_to' => 'Colombo Fort -> Badulla',
        'class' => '1st Class Observation',
        'seats' => '2 Seats',
        'date' => '2026-07-15'
    ],
    [
        'ticket_no' => 'TKT-3214',
        'passenger' => 'Nethmini Apsara',
        'train' => 'Yal Devi (4001)',
        'from_to' => 'Colombo Fort -> Jaffna',
        'class' => '2nd Class Conditioned',
        'seats' => '1 Seat',
        'date' => '2026-07-16'
    ],
    [
        'ticket_no' => 'TKT-7412',
        'passenger' => 'Mahesh Silva',
        'train' => 'Galu Kumari (8056)',
        'from_to' => 'Maradana -> Matara',
        'class' => '3rd Class Ordinary',
        'seats' => '4 Seats',
        'date' => '2026-07-15'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrainHub Admin - Passenger Bookings</title>
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
        
        /* 📊 Table Styling (අකුරු පැහැදිලිව කළු පාට කිරීම) */
        .table-custom {
            color: #000000 !important;
            border-color: #cbd5e1 !important;
        }
        .table-custom thead th {
            background-color: #334155 !important;
            color: #ffffff !important;
        }
        .table-custom td {
            color: #000000 !important; /* මුළු Table එකේම දත්ත කළු පැහැය කරයි */
            font-weight: 550; /* අකුරු ඝනකම් කර පැහැදිලිව පෙන්වයි */
        }
        .table-hover tbody tr:hover {
            background-color: #f1f5f9 !important;
        }
        .text-primary-custom {
            color: #1d4ed8 !important; /* Ticket No සඳහා තද නිල් පැහැය */
        }
        .table-icon {
            color: #475569 !important; /* Icon සඳහා තද අළු පැහැය */
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
                    <h2 class="text-dark mb-0"><i class="fa-solid fa-ticket text-primary"></i> Passengers Ticket Booking List</h2>
                    
                    <div class="no-print">
                        <button onclick="window.print();" class="btn btn-success fw-bold me-2">
                            <i class="fa-solid fa-file-pdf"></i> Download Ticket PDF
                        </button>
                        
                        <button type="button" onclick="window.location.href='dashboard.php';" class="btn btn-outline-dark fw-bold">
                            <i class="fa-solid fa-right-from-bracket"></i> Exit to Dashboard
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle table-custom bg-white">
                        <thead>
                            <tr class="text-white">
                                <th>Ticket No</th>
                                <th>Passenger Name</th>
                                <th>Train Details</th>
                                <th>Route (From -> To)</th>
                                <th>Class Type</th>
                                <th>Seats</th>
                                <th>Journey Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tickets as $tkt): ?>
                                <tr>
                                    <td class="fw-bold text-primary-custom"><?php echo $tkt['ticket_no']; ?></td>
                                    <td class="text-dark"><i class="fa-solid fa-user table-icon me-1"></i> <?php echo $tkt['passenger']; ?></td>
                                    <td class="text-dark"><i class="fa-solid fa-train table-icon me-1"></i> <?php echo $tkt['train']; ?></td>
                                    <td class="text-dark"><?php echo $tkt['from_to']; ?></td>
                                    <td><span class="badge bg-dark text-white"><?php echo $tkt['class']; ?></span></td>
                                    <td class="fw-bold text-center text-primary-custom"><?php echo $tkt['seats']; ?></td>
                                    <td class="text-dark"><?php echo $tkt['date']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-muted small text-center d-none d-print-block">
                    Report Generated Automatically via TrainHub Railway Management System.
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>