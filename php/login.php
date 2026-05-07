<?php
    session_start();
    include_once "config.php";
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    if(!empty($email) && !empty($password)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $sql->bind_param("s", $email);
            $sql->execute();
            $result = $sql->get_result();
            if($result->num_rows > 0){
               $row = mysqli_fetch_assoc($result);
               if(password_verify($password, $row['password'])){
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