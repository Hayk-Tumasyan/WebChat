<?php
//GET USERS
    while($row=mysqli_fetch_assoc($result)){
        $sql12 = "SELECT * FROM messages WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$row['unique_id']})
                  OR (outgoing_msg_id = {$row['unique_id']} AND incoming_msg_id = {$outgoing_id})
                  ORDER BY msg_id DESC LIMIT 1";

        $query2 = $conn->query($sql12);
        $row2 = mysqli_fetch_assoc($query2);
        $msg = "";
        $you = "";
        $ext = strtolower(pathinfo("php/uploadedFiles/".$row2['uploadedFile'], PATHINFO_EXTENSION));
        // echo $ext;
        if(mysqli_num_rows($query2)>0){
            $resultm = $row2['msg'];
            if(!empty($resultm) ){
                strlen($resultm) > 28 ? $msg = substr($resultm, 0, 28).'...' : $msg = $resultm;
            } else if(in_array($ext, ["docx", "txt", "zip", "pdf"])){
                $msg .= '<i class="fas fa-file-alt"></i>';
            } else{
                $msg .= '<img src="php/uploadedFiles/'.$row2['uploadedFile'].'" style="width: 20px; height: 20px; border-radius: 0%;">';
            }
        } else{
            $resultm = "no messages yet";
        }

         
        (mysqli_num_rows($query2)>0 && $row2['outgoing_msg_id']==$outgoing_id) ? $you = "You: " : $you = "";
        ($row['status'] == 0) ? $offline = "offline" : $offline = "";
        // $_SESSION['user_id'] = $row['unique_id'];
        $output .= '<a href="chat.php?user_id='.$row['unique_id'].'">
                <div class="content">
                    <img src="php/images/'. $row['img'] .'">
                    <div class="details">
                        <span>'. $row['fname'] . " " . $row['lname'] .'</span>
                        <p>'. $you .$msg .'</p>
                    </div>
                </div>
                <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
            </a>';
    }
?>