<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $output = "";

    // Select all users that the current user has already exchanged messages with
    $result = $conn->query("SELECT *
                            FROM users
                            WHERE users.unique_id != $outgoing_id
                            AND EXISTS (
                                SELECT 1
                                FROM messages
                                WHERE (
                                    (messages.outgoing_msg_id = $outgoing_id AND messages.incoming_msg_id = users.unique_id)
                                    OR
                                    (messages.incoming_msg_id = $outgoing_id AND messages.outgoing_msg_id = users.unique_id)
                                ))");
    if(mysqli_num_rows($result) == 0){
        $output .= "You haven't messaged anyone yet";
    } elseif(mysqli_num_rows($result) >= 1){
       include "data.php";
    }
    echo $output;
?>