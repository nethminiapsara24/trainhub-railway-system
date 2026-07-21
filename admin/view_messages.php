<?php
// සෙෂන් එක ආරම්භ කිරීම (අවශ්‍ය නම්)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ඩමි පණිවිඩ දත්ත සමුදාය (Mock Customer Messages Database)
$messages = [
    [
        'id' => 'MSG-001',
        'name' => 'Dinitha Mihisara',
        'email' => 'dinitha@gmail.com',
        'subject' => 'Ticket Cancellation Query',
        'message' => 'I want to know how to cancel my ticket booked for tomorrow and get a refund.',
        'date' => '2026-07-13',
        'status' => 'Unread'
    ],
    [
        'id' => 'MSG-002',
        'name' => 'Nethmini Apsara',
        'email' => 'nethmini@gmail.com',
        'subject' => 'Train Schedule Issue',
        'message' => 'The Yal Devi train schedule is not showing correctly on the mobile view.',
        'date' => '2026-07-13',
        'status' => 'Unread'
    ],
    [
        'id' => 'MSG-003',
        'name' => 'Mahesh Silva',
        'email' => 'mahesh@gmail.com',
        'subject' => 'Payment Success but No Ticket Received',
        'message' => 'My transaction was successful via Visa Card, but I did not receive the ticket PDF yet.',
        'date' => '2026-07-12',
        'status' => 'Read'
    ]
];

// Message Status Action Simulation
$alert_message = "";
if (isset($_GET['read_id'])) {
    $alert_message = "Message " . htmlspecialchars($_GET['read_id']) . " marked as read successfully!";
    if ($_GET['read_id'] == 'MSG-001') $messages[0]['status'] = 'Read';
    if ($_GET['read_id'] == 'MSG-002') $messages[1]['status'] = 'Read';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrainHub Admin - Customer Messages</title>
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
            font-weight: 500;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f5f9 !important;
        }
        .text-primary-custom {
            color: #1d4ed8 !important;
        }
        .msg-body-text {
            max-width: 300px;
            white-space: normal;
            word-wrap: break-word;
        }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card admin-card p-4 bg-white"> <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3 border-secondary-subtle">
                    <h2 class="text-dark mb-0"><i class="fa-solid fa-envelope text-primary"></i> Customer Messages & Queries</h2>
                    
                    <button type="button" onclick="window.location.href='dashboard.php';" class="btn btn-outline-dark fw-bold">
                        <i class="fa-solid fa-right-from-bracket"></i> Exit to Dashboard
                    </button>
                </div>

                <?php if (!empty($alert_message)): ?>
                    <div class="alert alert-success text-center py-2 small" role="alert">
                        <i class="fa-solid fa-circle-check"></i> <?php echo $alert_message; ?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle table-custom bg-white">
                        <thead>
                            <tr class="text-white">
                                <th>ID</th>
                                <th>Sender Info</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Received Date</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $msg): ?>
                                <tr>
                                    <td class="fw-bold text-primary-custom"><?php echo $msg['id']; ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?php echo $msg['name']; ?></div>
                                        <div class="text-muted small"><?php echo $msg['email']; ?></div>
                                    </td>
                                    <td class="text-dark fw-semibold"><?php echo $msg['subject']; ?></td>
                                    <td class="text-dark small msg-body-text"><?php echo $msg['message']; ?></td>
                                    <td class="text-dark"><?php echo $msg['date']; ?></td>
                                    <td>
                                        <?php if($msg['status'] == 'Unread'): ?>
                                            <span class="badge bg-danger text-white px-2">New / Unread</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary text-white px-2">Read</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($msg['status'] == 'Unread'): ?>
                                            <a href="view_messages.php?read_id=<?php echo $msg['id']; ?>" class="btn btn-sm btn-success fw-bold px-2 pt-0 pb-0 small" title="Mark as Read">
                                                <i class="fa-solid fa-check"></i> Read
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small"><i class="fa-solid fa-circle-check text-success"></i> Handled</span>
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