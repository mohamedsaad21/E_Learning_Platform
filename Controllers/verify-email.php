<?php

    session_start();
    include "../config/database.php";


    if(isset($_GET['token'])){
        $token = $_GET['token'];
        $verify_query = "SELECT verify_token FROM students WHERE verify_token = '$token'";
        $verify_query_run = mysqli_query($conn, $verify_query);

        if(mysqli_num_rows($verify_query_run) > 0){
            $row = mysqli_fetch_array($verify_query_run);

            if($row['verify_status'] == 0){
                $clicked_token = $row['verify_token'];
                $update_query = "UPDATE students SET verify_status = 1 WHERE verify_token = '$clicked_token'";
                $update_query_run = mysqli_query($conn, $update_query);
                
                if($update_query_run){
                    header("Location: ../Views/login.php?success=Your Account has been verified successfully.!");
                    exit(0);
                }
            }
        }
    }

?>