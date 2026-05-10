<?php
    session_start();
    include_once "config.php";
    $output = "";
    $outgoing_id = $_SESSION['unique_id']; // Current logged-in user's ID
    $input = trim($_POST['searchTerm']);  // Remove unnecessary spaces from input
    $searchTerm = $input;

    // Continue only if search input is not empty
    if($searchTerm != ""){
        // Split input into separate words and remove empty values
        $searchTerm = array_values(array_filter((explode(" ", $searchTerm))));

         // Search users except current user
        // Match by first name, last name, or similar sounding names
        $sql = $conn->prepare(
            "SELECT * FROM users 
            WHERE users.unique_id != ? 
            AND (
                (fname LIKE ?) 
                OR (lname LIKE ?) 
                OR (SOUNDEX(fname) = SOUNDEX(?)) 
                OR (SOUNDEX(lname) = SOUNDEX(?)))");

        // If user entered multiple words     
        if(count($searchTerm)>1){

            $fname=reset($searchTerm);
            $lname=end($searchTerm);
            $term1="%$fname%";
            $term2="%$lname%";
            $term3="$fname";
            $term4="$lname";
            $sql->bind_param("issss", $outgoing_id, $term1, $term2, $term3, $term4);
        } else { // Single-word search
            $term1="%$searchTerm[0]%";
            $term2="%$searchTerm[0]%";
            $term3="$searchTerm[0]";
            $term4="$searchTerm[0]";
            $sql->bind_param("issss", $outgoing_id, $term1, $term2, $term3, $term4);
        }
        
        $sql->execute();
        $result = $sql->get_result();
        if(mysqli_num_rows($result) > 0){
                include "data.php";
        } else{
            $output .= "No results found for ".implode(" ", $searchTerm);
        }
    }
    
    echo $output;
?>