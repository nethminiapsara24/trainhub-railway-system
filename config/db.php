<?php
// ==========================================
// trainhub/config/db.php
// DATABASE CONNECTION CONFIGURATION (PDO)
// ==========================================

// 1. සර්වර් එකේ දත්ත සැකසීම (Credentials)
$host = 'localhost';         // XAMPP / WAMP වල සාමාන්‍ය සර්වර් නාමය
$db   = 'trainhub_db';       // පෙර පියවරේදී ඔබ phpMyAdmin හි සෑදූ Database නම
$user = 'root';             // XAMPP හි default username එක
$pass = '';                 // XAMPP හි default password එක (හිස්ව තබන්න)
$charset = 'utf8mb4';        // සිංහල/දෙමළ අකුරු නිවැරදිව පෙන්වීමට යුනිකෝඩ් සංකේත ක්‍රමය

// 2. PDO Data Source Name (DSN) එක සැකසීම
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// 3. පද්ධතියේ ආරක්ෂාව සහ දෝෂ හඳුනාගැනීමේ විකල්ප (PDO Options)
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // වැරැද්දක් වූ විට Error එකක් පෙන්වීමට
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // දත්ත Array එකක් ලෙස ලබා ගැනීමට
    PDO::ATTR_EMULATE_PREPARES   => false,                  // SQL Injection වලින් ආරක්ෂා වීමට අනිවාර්යයි
];

// 4. සර්වර් එක සම්බන්ධ කිරීම සහ දෝෂ පාලනය (Try-Catch Block)
try {
    // සර්වර් එක සාර්ථකව සම්බන්ධ කිරීම
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // (පරීක්ෂා කිරීම සඳහා පමණි) සාර්ථක නම් කිසිවක් පෙන්වන්නේ නැත, කෙලින්ම පිටුව වැඩ කරයි.
} catch (\PDOException $e) {
    // සර්වර් එක සම්බන්ධ වීමට නොහැකි වුවහොත් පෙන්වන පණිවිඩය (උදා: Error 200 වැනි දේ මඟහරවයි)
    die("දුම්රිය දත්ත පද්ධතියට සම්බන්ධ වීමට නොහැකි විය: " . $e->getMessage());
}
?>