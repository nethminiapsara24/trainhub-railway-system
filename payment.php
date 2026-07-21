<?php
$message = "";
$message_class = "";
$ticket_amount = "LKR 1,500.00"; 

// Form එක Submit වූ පසු ක්‍රියාත්මක වන කොටස
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'card';
    
    sleep(1); // Processing Simulation
    
    if ($payment_method == 'wallet') {
        $mobile_no = trim($_POST['mobile_no']);
        $message = "OTP Sent successfully to $mobile_no! Mobile wallet payment of $ticket_amount processed successfully.";
    } elseif ($payment_method == 'bank') {
        $message = "Bank Transfer Request Received! Please upload the receipt within 24 hours to confirm your ticket.";
    } else {
        $message = "Card Payment Successful! Your train ticket has been reserved and confirmed.";
    }
    
    $message_class = "alert-success";
    
    // සාර්ථක වූ පසු Dashboard එකට රීඩිරෙක්ට් වීමට:
   // header("refresh:4;url=dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrainHub - Local Secure Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .payment-card { border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: none; }
        .btn-pay { background-color: #2c3e50; border: none; color: white; font-weight: bold; }
        .btn-pay:hover { background-color: #1a252f; }
        .nav-pills .nav-link { color: #495057; font-weight: 500; border: 1px solid #dee2e6; margin-bottom: 5px; }
        .nav-pills .nav-link.active { background-color: #2c3e50; border-color: #2c3e50; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card payment-card p-4">
                <h4 class="text-center mb-4"><i class="fa-solid fa-shield-halved text-success"></i> TrainHub Sri Lankan Checkout</h4>
                
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded">
                    <span class="fw-bold text-secondary">Total Amount to Pay:</span>
                    <span class="text-primary fw-bold fs-4"><?php echo $ticket_amount; ?></span>
                </div>

                <?php if (!empty($message)): ?>
                 <div class="alert <?php echo $message_class; ?> text-center p-3" role="alert">
                    <h5 class="alert-heading"><i class="fa-solid fa-circle-check"></i> Success!</h5>
                    <p class="mb-2"><?php echo $message; ?></p>
                    <hr>
                  <a href="dashboard.php" class="btn btn-success btn-sm fw-bold">
                     <i class="fa-solid fa-house"></i> Go to Dashboard
                  </a>
                 </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-4">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active text-start" id="v-pills-card-tab" data-bs-toggle="pill" data-bs-target="#v-pills-card" type="button" role="tab"><i class="fa-solid fa-credit-card me-2"></i> Visa / Master</button>
                            <button class="nav-link text-start" id="v-pills-wallet-tab" data-bs-toggle="pill" data-bs-target="#v-pills-wallet" type="button" role="tab"><i class="fa-solid fa-mobile-screen me-2"></i> eZ Cash / mCash</button>
                            <button class="nav-link text-start" id="v-pills-bank-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bank" type="button" role="tab"><i class="fa-solid fa-building-columns me-2"></i> Bank Transfer</button>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="tab-content p-3 border rounded bg-white" id="v-pills-tabContent">
                            
                            <div class="tab-pane fade show active" id="v-pills-card" role="tabpanel">
                                <form action="payment.php" method="POST">
                                    <input type="hidden" name="payment_method" value="card">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Cardholder Name</label>
                                        <input type="text" class="form-control" name="card_name" required placeholder="Name on Card">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Card Number</label>
                                        <input type="text" class="form-control" name="card_number" maxlength="19" required placeholder="1234 5678 9101 1121">
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3"><label class="form-label small fw-bold">Expiry</label><input type="text" class="form-control" placeholder="MM/YY" required></div>
                                        <div class="col-6 mb-3"><label class="form-label small fw-bold">CVV</label><input type="password" class="form-control" placeholder="123" required></div>
                                    </div>
                                    <button type="submit" class="btn btn-pay w-100 py-2 mt-2">Pay via Card</button>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="v-pills-wallet" role="tabpanel">
                                <form action="payment.php" method="POST">
                                    <input type="hidden" name="payment_method" value="wallet">
                                    <p class="text-muted small">Pay securely using your Dialog eZ Cash or Mobitel mCash account.</p>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Select Wallet Type</label>
                                        <select class="form-select" required>
                                            <option value="ezcash">Dialog eZ Cash</option>
                                            <option value="mcash">Mobitel mCash</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Mobile Number</label>
                                        <input type="text" class="form-control" name="mobile_no" maxlength="10" required placeholder="0771234567">
                                    </div>
                                    <button type="submit" class="btn btn-pay w-100 py-2 mt-2">Request OTP & Pay</button>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="v-pills-bank" role="tabpanel">
                                <form action="payment.php" method="POST">
                                    <input type="hidden" name="payment_method" value="bank">
                                    <p class="text-muted small">Deposit to our Bank Account and upload the receipt image.</p>
                                    <div class="p-2 mb-3 bg-light rounded text-dark small font-monospace">
                                        <strong>Bank:</strong> Bank of Ceylon (BOC)<br>
                                        <strong>Account Name:</strong> TrainHub Railway Ltd<br>
                                        <strong>Account No:</strong> 123456789
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Upload Deposit Slip / Receipt</label>
                                        <input type="file" class="form-control" required accept="image/*">
                                    </div>
                                    <button type="submit" class="btn btn-pay w-100 py-2 mt-2">Submit Receipt</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="text-center mt-4 text-muted small border-top pt-3">
                    <i class="fa-solid fa-lock text-muted"></i> Secured by Central Bank of Sri Lanka Certified Gateway Standards
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>