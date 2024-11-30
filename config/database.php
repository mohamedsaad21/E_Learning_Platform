<?php

    $conn = mysqli_connect("localhost", "root", "", "ELearning");
    if(!$conn){
        echo mysqli_connect_error();
    }

?>