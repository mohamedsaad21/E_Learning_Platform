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

    if(empty($email)){
        $_SESSION['error'] = "Email is required";
        header("Location: ../Views/login.php");
    }else if(empty($password)){
        $_SESSION['error'] = "Password is required";
        header("Location: ../Views/login.php");
    }

    $sql = "SELECT *, role_name FROM users INNER JOIN roles ON roles.role_id = users.role_id WHERE Email = '$email' AND Password = '$password'";
    
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        if($row['Email'] === $email && $row['Password'] === $password){
            $_SESSION['username'] = $row['Username'];
            $_SESSION['Email'] = $row['Email'];
            $_SESSION['user_id'] = $row['Id'];
            $_SESSION['role'] = $row['role_name'];
            $_SESSION['Name'] = $row['firstname'] . " " . $row['lastname'];
            header("Location: ../index.php");
        }else{
            $_SESSION['Email'] = $email;
            $_SESSION['error'] = "Incorrect Email or Password";
            header("Location: ../Views/login.php");
        }
    }else{
        $_SESSION['Email'] = $email;
        $_SESSION['error'] = "Incorrect Email or Password";
        header("Location: ../Views/login.php");
    }
?>