<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        
        $outgoing_id = $_SESSION['unique_id'];
        $incoming_id = $_POST['incoming_id'];
        date_default_timezone_set('Asia/Yerevan');
        $filePath = "";
        $fileHTML = "";
        $output="";

        // Fetch chat messages between two users
        $sql = $conn->prepare("SELECT * FROM messages 
                                LEFT JOIN users on users.unique_id = messages.outgoing_msg_id
                                WHERE 
                                    (outgoing_msg_id = ? AND incoming_msg_id = ?)
                                    OR
                                    (outgoing_msg_id = ? AND incoming_msg_id = ?)
                                ORDER BY msg_id ASC");
        $sql->bind_param("iiii", $outgoing_id, $incoming_id, $incoming_id, $outgoing_id);
        if(!$sql->execute()){
            die("Error: " . $sql->error);
        }
        $result = $sql->get_result();

        if(mysqli_num_rows($result) > 0){
            // Loop through all messages
            while($row = mysqli_fetch_assoc($result)){
                $fileHTML = "";
                $classActive = "";
                $messageHTML = "";
                $timestamp = $row['sent_at'];
                    
                
                if(!empty($row['uploadedFile'])){
                        $filePath = "php/uploadedFiles/".$row['uploadedFile'];

                        $classActive = "active";
                        
                        $ext = strtolower(pathinfo($row['uploadedFile'], PATHINFO_EXTENSION));
                        
                        // If file is an image AND message exists
                        if(in_array($ext, ["jpeg", "jpg", "png", "gif"]) && !empty($row['msg'])){
                            $fileHTML = '<img src="'.$filePath.'" >';
                            $messageHTML = '<p class = "'.$classActive.'">'.$row['msg'].'</p>';
                        } 

                        // If file is image only
                        else if(in_array($ext, ["jpeg", "jpg", "png", "gif"])){
                            $fileHTML = '<img class="'.$classActive.'" src="'.$filePath.'" >';
                        }

                        // If no file, only text message
                        else{
                            $fileName = basename($filePath);

                            $fileHTML = '<a class="file-download" href="'.$filePath.'" download>'.$fileName.'</a>';
                        }
                }else{
                    $messageHTML = '<p>'.$row['msg'].'</p>';
                }

                // Outgoing message (sent by current user)
                if($row['outgoing_msg_id'] == $outgoing_id){
                    $output .= '<div class="chat outgoing">
                                        <div class="details">
                                            '.$fileHTML.'
                                            '.$messageHTML.'
                                             <span>'.date("H:i", $timestamp).'</span>                                            
                                        </div>
                                </div>';
                }
                
                // Incoming message (received from other user)
                else{
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