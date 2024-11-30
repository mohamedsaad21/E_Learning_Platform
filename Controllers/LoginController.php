<?php
    session_start();
    include "../config/database.php";
    if(isset($_POST['email']) && isset($_POST['password'])){        
        function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    }
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $MyRole = $_POST['rule'];

    if(empty($email)){
        header("Location: ../Views/login.php?error=Email is required");
        exit();
    }else if(empty($password)){
        header("Location: ../Views/login.php?error=Password is required");
    }
    if($MyRole === 'student'){
        $sql = "SELECT * FROM Students WHERE Email = '$email' AND Password = '$password'";
    }else if($MyRole === 'instructor'){        
        $sql = "SELECT * FROM Instructors WHERE Email = '$email' AND Password = '$password'";
    }else{
        header("Location: ../Views/login.php?error=Choose Student or Instructor");
    }

    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        if($row['Email'] === $email && $row['Password'] === $password){
            $_SESSION['Email'] = $row['Email'];
            $_SESSION['Id'] = $row['Id'];
            header("Location:../index.php");
        }else{
            header("Location: ../Views/login.php?error=Incorrect userName or Password");
            exit();
        }
    }else{
        header("Location: ../Views/login.php?error=Incorrect userName or Password");
        exit();
    }
?>