<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = $_POST['message'];
        $file_new_name = "";
        $sent_at = time();

        // File upload handling
       if(isset($_FILES['inputFile']) && $_FILES['inputFile']['error'] === 0){
            $file_name = $_FILES['inputFile']['name'];
            $tmp_name = $_FILES['inputFile']['tmp_name'];

            //get file extension
            $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            if(in_array($ext, ["jpg", "jpeg", "png", "gif", "pdf", "txt", "docx", "zip"])){
                $time = time();
                $file_new_name = $time.$file_name;

                move_uploaded_file($tmp_name, "uploadedFiles/".$file_new_name);
            } else{
                die($file_name." Can't be sent");
            }
            
        }

        // Insert message only if something exists
        if(!empty($message) || !empty($file_new_name)){
                    $sql = $conn->prepare("INSERT INTO messages (outgoing_msg_id, incoming_msg_id, msg, uploadedFile, sent_at) VALUES (?, ?, ?, ?, ?)");
                    $sql->bind_param("iissi", $outgoing_id, $incoming_id, $message, $file_new_name, $sent_at);
                    if(!$sql->execute()){
                        die("Error: " . $sql->error);
                    }
            }
        }
    else{
        header("location: ../login.php");
    }
    
?>