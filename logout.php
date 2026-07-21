<?php
// ====================================================================
// PROJECT NAME: TrainHub Railway System
// FILE NAME: logout.php
// DESCRIPTION: Securely destroy user session and redirect to home
// ====================================================================

// 1. Session එක දැනටමත් ක්‍රියාත්මක දැයි බලා එය ආරම්භ කිරීම
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 2. සෙෂන් එකේ ඇති සියලුම දත්ත (User ID, Name, Role) මකා දැමීම
$_SESSION = array();

// 3. බ්‍රවුසර් එකේ ඇති Session Cookie එකත් සම්පූර්ණයෙන්ම විනාශ කිරීම
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. සෙෂන් එක සර්වර් එකෙන් සම්පූර්ණයෙන්ම විනාශ කිරීම (Destroy)
session_destroy();

// 5. මගියාව ආරක්ෂිතව මුල් පිටුවට (Home Page) හරවා යැවීම
header("Location: index.php");
exit();
?>