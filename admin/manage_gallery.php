<?php
// 1. admin ෆෝල්ඩර් එකෙන් පියවරක් පිටතට පැමිණ ඩේටාබේස් එක සම්බන්ධ කිරීම
require_once '../config/db.php'; 

// 🔍 ඩේටාබේස් කනෙක්ෂන් variable එක කුමක්දැයි ස්වයංක්‍රීයව හඳුනාගැනීම ($conn, $con, හෝ $db)
if (!isset($conn)) {
    if (isset($con)) { $conn = $con; }
    elseif (isset($db)) { $conn = $db; }
    elseif (isset($connection)) { $conn = $connection; }
}

// කනෙක්ෂන් එක object එකක් නොවේ නම් මුල ඉඳන්ම trainhub_db එකට සාදා ගැනීම
if (!is_object($conn)) {
    $conn = new mysqli("localhost", "root", "", "trainhub_db");
}

$message = "";

// 📸 2. Image Upload Logic (ඔයාගේ Table එකටම ගැලපෙන්න සකසා ඇත)
if (isset($_POST['upload_image'])) {
    $caption = htmlentities(trim($_POST['title']), ENT_QUOTES, 'UTF-8'); // title -> caption
    $upload_cat = htmlentities($_POST['category'], ENT_QUOTES, 'UTF-8'); // category -> upload
    
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
        $target_dir = "../upload/"; 
        $filename = time() . '_' . basename($_FILES['image_file']['name']);
        $target_filepath = $target_dir . $filename;
        
        // පින්තූරය පරිගණකයෙන් trainhub/upload/ ෆෝල්ඩර් එකට මාරු කිරීම
        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_filepath)) {
            
            // 📝 ඔයාගේ phpMyAdmin ව්‍යුහයට 100% ගැලපෙන SQL Query එක (id, image_name, caption, upload)
            $insert_query = "INSERT INTO gallery (image_name, caption, upload) VALUES ('$filename', '$caption', '$upload_cat')";
            
            if ($conn->query($insert_query)) {
                $message = "🎉 Photo '$caption' uploaded and saved to database successfully!";
            } else {
                $message = "❌ Database Error: " . $conn->error;
            }
        } else {
            $message = "❌ Error: Failed to move file to upload folder. Check folder path.";
        }
    } else {
        $message = "❌ Error: Please select a valid image.";
    }
}

// 🗑️ 3. Delete Logic
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    $find_query = "SELECT image_name FROM gallery WHERE id = $delete_id";
    $find_result = $conn->query($find_query);
    if ($find_result && $find_result->num_rows > 0) {
        $row = $find_result->fetch_assoc();
        $full_del_path = "../upload/" . $row['image_name'];
        if (file_exists($full_del_path)) {
            unlink($full_del_path); 
        }
    }
    
    $delete_query = "DELETE FROM gallery WHERE id = $delete_id";
    if ($conn->query($delete_query)) {
        $message = "🗑️ Photo removed successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrainHub Admin - Manage Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #1e293b; color: #f8fafc; font-family: 'Segoe UI', sans-serif; }
        .admin-card { background-color: #0f172a; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); border: 1px solid #334155; }
        .form-control, .form-select { background-color: #1e293b !important; border: 1px solid #475569 !important; color: #ffffff !important; }
        
        .gallery-box { background-color: #ffffff !important; border-radius: 10px; overflow: hidden; border: 1px solid #cbd5e1; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .gallery-box .card-body { padding: 15px; }
        .gallery-title { color: #000000 !important; font-weight: 600; font-size: 1.05rem; margin-bottom: 5px; }
        .gallery-category { color: #475569 !important; font-size: 0.85rem; font-weight: 500; }
        .gallery-img { height: 170px; object-fit: cover; width: 100%; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row">
        
        <div class="col-md-4 mb-4">
            <div class="card admin-card p-4">
                <h4 class="text-white mb-3"><i class="fa-solid fa-cloud-arrow-up" style="color:#38bdf8;"></i> Upload to Gallery</h4>
                <hr class="border-secondary">
                
                <form action="manage_gallery.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-white-50">Photo Title (Caption)</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter Caption" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-white-50">Category</label>
                        <select class="form-select" name="category" required>
                            <option value="train">Train</option>
                            <option value="station">Station</option>
                            <option value="event">Event</option>
                            <option value="Ella Train">Ella Train</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-white-50">Select Image from PC</label>
                        <input type="file" class="form-control" name="image_file" accept="image/*" required>
                    </div>
                    
                    <button type="submit" name="upload_image" class="btn btn-primary w-100 fw-bold mt-2" style="background-color: #38bdf8; border: none; color: #0f172a;">
                        <i class="fa-solid fa-upload"></i> Upload Now
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card admin-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3 border-secondary">
                    <h2 class="text-white mb-0"><i class="fa-solid fa-images text-info"></i> Gallery Management</h2>
                    <button type="button" onclick="window.location.href='dashboard.php';" class="btn btn-outline-light btn-sm fw-bold">
                        <i class="fa-solid fa-right-from-bracket"></i> Exit
                    </button>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-info text-center py-2 small fw-bold" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <?php
                    // ඩේටාබේස් එකෙන් දත්ත කියවීම
                    $select_query = "SELECT * FROM gallery ORDER BY id DESC";
                    $query_run = $conn->query($select_query);

                    if ($query_run && $query_run->num_rows > 0) {
                        while($row = $query_run->fetch_assoc()) {
                            // phpMyAdmin එකට අනුව නිවැරදි column keys ලබා ගැනීම
                            $img_id = $row['id'];
                            $img_title = !empty($row['caption']) ? $row['caption'] : 'Untitled Image';
                            $img_category = !empty($row['upload']) ? $row['upload'] : 'General';
                            
                            // පින්තූරය පෙන්වීමට image path එක සකස් කිරීම
                            $img_src = "../upload/" . $row['image_name'];
                            ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card gallery-box">
                                    <img src="<?php echo $img_src; ?>" class="gallery-img" alt="TrainHub">
                                    <div class="card-body">
                                        <div class="gallery-title text-truncate"><?php echo $img_title; ?></div>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="badge bg-dark text-white text-capitalize"><?php echo $img_category; ?></span>
                                            <a href="manage_gallery.php?delete_id=<?php echo $img_id; ?>" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="return confirm('Are you sure you want to delete this photo?');">
                                                <i class="fa-solid fa-trash-can small"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div class="col-12 text-center text-muted py-5">No images found in database.</div>';
                    }
                    ?>
                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>