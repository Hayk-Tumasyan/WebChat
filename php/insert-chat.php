<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        $file_new_name = "";
        $timestamp = time();

       if(isset($_FILES['inputFile']) && $_FILES['inputFile']['error'] === 0){
            $file_name = $_FILES['inputFile']['name'];
            $tmp_name = $_FILES['inputFile']['tmp_name'];

            //get file extension
            $file_explode = explode(".", $file_name);
            $file_ext = strtolower(end($file_explode));

            $time = time();
            $file_new_name = $time.$file_name;

            move_uploaded_file($tmp_name, "files/".$file_new_name);
        }

        if(!empty($message) || !empty($file_new_name)){
                    $sql = $conn->prepare("INSERT INTO messages (outgoing_msg_id, incoming_msg_id, msg, uploadedFile, sent_at) VALUES (?, ?, ?, ?, ?)");
                    $sql->bind_param("iissi", $outgoing_id, $incoming_id, $message, $file_new_name, $timestamp);
                    if(!$sql->execute()){
                        die("Error: " . $sql->error);
                    }
            }
            
            // $sql = $conn->prepare("INSERT INTO messages (outgoing_msg_id, incoming_msg_id, msg) VALUES (?, ?, ?)");
            // $sql->bind_param("iis", $outgoing_id, $incoming_id, $message);
            // if(!$sql->execute()){
            //     die("Error: " . $sql->error);
            // }
        }
        // if(isset($_FILES['inputFile']) && $_FILES['inputFile']['error'] === 0){
        //             $file_name = $_FILES['inputFile']['name'];
        //             $tmp_name = $_FILES['inputFile']['tmp_name'];

        //             //get file extension
        //             $file_explode = explode(".", $file_name);
        //             $file_ext = strtolower(end($file_explode));

        //             $time = time();
        //             $file_new_name = $time.$file_name;

        //             if(move_uploaded_file($tmp_name, "files/".$file_new_name)){ //if user uploaded file moved to our folder successfully
        //                 //insert all user data to database
        //                 $sql12 = $conn->prepare("INSERT INTO messages (inputFile)
        //                                         VALUES(?)");
        //                 $sql12->bind_param("s", $file_new_name);
        //                 $sql12->execute();
        //             }
        //         }
    else{
        header("location: ../login.php");
    }
    
?>