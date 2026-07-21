<?php
// ====================================================================
// PROJECT NAME: TrainHub Railway System
// FILE NAME: gallery.php
// DESCRIPTION: Restored Original Gallery - Fixed for "upload" Folder Path
// ====================================================================

// 1. Include Header
require_once 'includes/header.php';

// 2. Get Database Connection
require_once 'config/db.php';

// Fetch gallery data
try {
    $stmt = $pdo->query("SELECT * FROM gallery ORDER BY id DESC");
    $gallery_items = $stmt->fetchAll();
} catch (\PDOException $e) {
    $gallery_items = [];
}
?>

<div class="container my-5">
    <div class="text-center mb-5">
        <span class="badge bg-info text-dark mb-2 px-3 py-2 text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px;">Visual Heritage</span>
        <h1 class="fw-bold text-dark">TrainHub Digital Gallery</h1>
        <p class="text-muted">Explore breathtaking moments and historical events captured across Sri Lankan Railways.</p>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        <?php if (!empty($gallery_items) && count($gallery_items) > 0): ?>
            <?php foreach ($gallery_items as $item): 
                // 🔥 ඔබේ සැබෑ ෆෝල්ඩරයේ නම වන "upload/" ලෙස මෙතැන නිවැරදි කරන ලදී.
                // ඩේටාබේස් එකේ ඇති WhatsApp Image වල තියෙන Spaces (හිස්තැන්) Encode කිරීම ද සිදුකර ඇත.
                $encoded_image_name = rawurlencode($item['image_name']);
                $image_src = "upload/" . $encoded_image_name;
            ?>
                <div class="col">
                    <div class="card h-100 bg-dark text-white border-0 shadow-lg rounded-3 overflow-hidden position-relative group">
                        
                        <span class="badge bg-info text-dark position-absolute top-0 start-0 m-3 fw-bold text-uppercase z-3 shadow-sm" style="font-size: 10px;">
                            <?php echo htmlspecialchars($item['category'] ?? 'Event'); ?>
                        </span>

                        <div class="overflow-hidden" style="height: 220px; background-color: #1e293b;">
                            <img src="<?php echo $image_src; ?>" 
                                 class="card-img-top w-100 h-100 object-fit-cover transition-all" 
                                 alt="Gallery Image">
                        </div>

                        <div class="card-body p-3 bg-secondary bg-opacity-10">
                            <p class="card-text small text-white-50 m-0 text-capitalize fw-semibold">
                                <i class="fa-solid fa-camera-retro text-info me-2"></i><?php echo htmlspecialchars($item['title'] ?? 'TrainHub Event'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fa-solid fa-images display-4 text-muted mb-3 d-block"></i>
                <p class="text-muted">No images available inside the digital gallery repository.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .card:hover img {
        transform: scale(1.08);
    }
</style>

<?php 
// 3. Include Footer
require_once 'includes/footer.php'; 
?>