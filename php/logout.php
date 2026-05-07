<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $sql = $conn->query("UPDATE users SET status = 0 WHERE users.unique_id = {$_SESSION['unique_id']}");


        session_unset();

        if(ini_get("session.use_cookies")){
            $params = session_get_cookie_params();
            setcookie(session_name(), "", time() - 42000, $params['path'], 
            $params['domain'], $params['secure'], $params['httponly']);

            session_destroy();
        } 

        header("location: ../login.php"); 
    } else {
        header("location: ../login.php");
    }
    
?>