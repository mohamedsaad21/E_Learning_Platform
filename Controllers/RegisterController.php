<?php
    session_start();
    include "../config/database.php";
    if(isset($_POST['submit'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $MyRole = $_POST['rule'];

        $validEmail = "SELECT `Email` FROM Students WHERE Email = '$email'";
        if($email === $validEmail){
            header("Location: ../Views/register.php?error=Email Already Exists");
        }
        $validEmail = "SELECT `Email` FROM Instructors WHERE Email = '$email'";
        if($email === $validEmail){
            header("Location: ../Views/register.php?error=Email Already Exists");
        }

        if($password === $confirmPassword){
            if($MyRole === 'student'){                
                $query = "INSERT INTO `Students`(`FirstName`, `LastName`, `Username`, `Email`, `Password`) VALUES ('$firstname','$lastname','$username','$email','$password')";
                mysqli_query($conn, $query);            
                header("Location:../index.php");
            }else if($MyRole === 'instructor'){
                $query = "INSERT INTO `Instructors`(`FirstName`, `LastName`, `Username`, `Email`, `Password`) VALUES ('$firstname','$lastname','$username','$email','$password')";
                mysqli_query($conn, $query);            
                header("Location:../index.php");
            }else{
                header("Location: ../Views/register.php?error=Choose Student or Instructor");
            }
        }else{
            header("Location: ../Views/register.php?error=Passwords do not match");
        }
    }
?>