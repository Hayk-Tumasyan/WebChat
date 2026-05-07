<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        
        $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        date_default_timezone_set('Asia/Yerevan');
        $filePath = "";
        $fileHTML = "";
        $output="";

        $sql = $conn->prepare("SELECT * FROM messages 
                                LEFT JOIN users on users.unique_id = messages.outgoing_msg_id
                                WHERE 
                                    (outgoing_msg_id = ? AND incoming_msg_id = ?)
                                    OR
                                    (outgoing_msg_id = ? AND incoming_msg_id = ?)
                                ORDER BY msg_id");
        $sql->bind_param("iiii", $outgoing_id, $incoming_id, $incoming_id, $outgoing_id);
        if(!$sql->execute()){
            die("Error: " . $sql->error);
        }
        $result = $sql->get_result();

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $fileHTML = "";
                $classActive = "";
                $messageHTML = "";

                if(!empty($row['sent_at'])){
                        $timestamp = $row['sent_at'];
                    } else{
                        $timestamp = 0;
                    }

                if(!empty($row['uploadedFile'])){
                        $filePath = "php/uploadedFiles/".$row['uploadedFile'];

                        $classActive = "active";
                        
                        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                        if(in_array($ext, ["jpeg", "jpg", "png", "gif"]) && !empty($row['msg'])){
                            $fileHTML = '<img src="'.$filePath.'" >';
                            $messageHTML = '<p class = "'.$classActive.'">'.$row['msg'].'</p>';
                        } else if(in_array($ext, ["jpeg", "jpg", "png", "gif"])){
                            $fileHTML = '<img class="'.$classActive.'"src="'.$filePath.'" >';
                        } else{
                            $fileName = basename($filePath);

                            $fileHTML = '<a class="file-download" href="'.$filePath.'" download>'.$fileName.'</a>';
                        }
                }else{
                    $messageHTML = '<p>'.$row['msg'].'</p>';
                }

                if($row['outgoing_msg_id'] == $outgoing_id){
                    $output .= '<div class="chat outgoing">
                                        <div class="details">
                                            '.$fileHTML.'
                                            '.$messageHTML.'
                                             <span>'.date("H:i", $timestamp).'</span>                                            
                                        </div>
                                </div>';
                } else{
                    $output .= '<div class="chat incoming">
                                    <img class="pfp" src="php/images/'.$row['img'].'">
                                    <div class="details">
                                        '.$fileHTML.'
                                        '.$messageHTML.'
                                        <span>'.date("H:i", $timestamp).'</span>
                                    </div>
				                </div>';
                }
            }
        }
        echo $output;
    }
    
?>