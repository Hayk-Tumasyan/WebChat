<?php
    session_start();
    include_once "config.php";

    $fname = $conn->real_escape_string($_POST['fName']);
    $lname = $conn->real_escape_string($_POST['lName']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        //email validation
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql = $conn->prepare("SELECT email FROM users WHERE email = ?");
            $sql->bind_param("s", $email);
            $sql->execute();
            $result = $sql->get_result();
            if($result->num_rows > 0){ //if email already exists
                echo "{$email} email already exists!";
            } else{

                $random_id = rand(time(), 1000000); //creating random id for a user
                $status = 1; //once user signed up his status will be active now
                $hash = password_hash($password, PASSWORD_DEFAULT); //hash the password

               // uploaded image
               if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
                    $img_name = $_FILES['image']['name'];
                    $tmp_name = $_FILES['image']['tmp_name'];

                    //get file extension
                    $img_explode = explode(".", $img_name);
                    $img_ext = strtolower(end($img_explode));

                    $extensions = ["jpg", "png", "jpeg"];
                    if(in_array($img_ext, $extensions) === true){
                        $time = time();

                        $img_new_name = $time.$img_name;

                        if(move_uploaded_file($tmp_name, "images/".$img_new_name)){ //if user uploaded img moved to our folder successfully
                            //insert all user data to database
                            $sql12 = $conn->prepare("INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                                    VALUES(?, ?, ?, ?, ?, ?, ?)");
                            $sql12->bind_param("isssssi", $random_id, $fname, $lname, $email, $hash, $img_new_name, $status);

                            //session unique id
                            if($sql12->execute()){  //if data inserted successfully
                                $sql13 = $conn->prepare("SELECT * FROM users WHERE email = ?");
                                $sql13->bind_param("s", $email);
                                $sql13->execute();
                                $result13 = $sql13->get_result();
                                if($result13->num_rows > 0){
                                    $row = mysqli_fetch_assoc($result13);
                                    $_SESSION['unique_id'] = $row['unique_id'];
                                    echo "success";
                                }
                            }
                        }

                        

                    } else{
                        echo "Please select an image file of .png, .jpg or .jpeg format";
                    }

               } else{
                      $sql12 = $conn->prepare("INSERT INTO users (unique_id, fname, lname, email, password, status)
                                                    VALUES(?, ?, ?, ?, ?, ?)");
                            $sql12->bind_param("issssi", $random_id, $fname, $lname, $email, $hash, $status);

                            //session unique id
                            if($sql12->execute()){  //if data inserted successfully
                                $sql13 = $conn->prepare("SELECT * FROM users WHERE email = ?");
                                $sql13->bind_param("s", $email);
                                $sql13->execute();
                                $result13 = $sql13->get_result();
                                if($result13->num_rows > 0){
                                    $row = mysqli_fetch_assoc($result13);
                                    $_SESSION['unique_id'] = $row['unique_id'];
                                    echo "success";
                                }
                            }           
               }
            }
        } else{
            echo "{$email} is not a valid email";
        }
    } else{
        echo "All input fields are required!";
    }
?>