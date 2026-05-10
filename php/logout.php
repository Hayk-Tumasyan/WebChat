<?php 
    session_start();
    // Check if user is logged in
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";

        // Set user status to offline
        $sql = $conn->query(
            "UPDATE users 
            SET status = 0 
            WHERE users.unique_id = {$_SESSION['unique_id']}");

        // Remove all session variables
        session_unset();

        // Delete session cookie if cookies are enabled
        if(ini_get("session.use_cookies")){
            $params = session_get_cookie_params();
            setcookie(
                session_name(), 
                "", 
                time() - 42000, 
                $params['path'], 
                $params['domain'], 
                $params['secure'], 
                $params['httponly']);
        } 

        // Destroy the session completely
        session_destroy();

        // Redirect to login page
        header("location: ../login.php"); 
        exit();
    } else {
        // If user is not logged in
        header("location: ../login.php");
        exit();
    }
    
?>