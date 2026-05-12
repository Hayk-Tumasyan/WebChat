<?php
    session_start();
    require_once __DIR__ . "/csrf.php";
    if (!csrf_verify($_POST["csrf_token"] ?? "")) {
        echo "Invalid security token. Refresh the page and try again.";
        exit;
    }
    require_once __DIR__ . "/config.php";
    // Get form data
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if fields are filled
    if(!empty($email) && !empty($password)){
        // Validate email format
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            // Find user by email
            $sql = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $sql->bind_param("s", $email);
            $sql->execute();
            $result = $sql->get_result();

            // If user exists
            if($result->num_rows > 0){
               $row = $result->fetch_assoc();

               // Verify password
               if(password_verify($password, $row['password'])){
               // Prevent session fixation
                session_regenerate_id(true);

                // Store logged-in user ID
                $_SESSION['unique_id'] = $row['unique_id'];
                
                $sql12 = $conn->query("UPDATE users SET status = 1 WHERE users.unique_id = {$_SESSION['unique_id']}");
                echo "success";
               } else{
                echo "Email or password is wrong!";
               }
            } else {
                echo "Email or password is wrong!";
            }
        } else {
            echo "'{$email}' is not valid!";
        }
    } else{
        echo "All fields are required!";
    }

?>