<?php
    session_start();
    include "../config/database.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

function sendemail_verify($name, $email, $verify_token) {
    try {
        $mail = new PHPMailer(true);

        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Disable debug output for production
        $mail->isSMTP();                                         // Send using SMTP
        $mail->Host       = 'smtp.outlook.com';                  // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                // Enable SMTP authentication
        $mail->Username   = 'elearningOOPS@outlook.com';         // SMTP username
        $mail->Password   = 'Ad@123456789#!';                    // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption
        $mail->Port       = 587;                                 // TCP port to connect to

        //Recipients
        $mail->setFrom('elearningOOPS@outlook.com', 'E-Learning Platform');
        $mail->addAddress($email, $name);                        // Add recipient

        //Content
        $mail->isHTML(true);                                     // Set email format to HTML
        $mail->Subject = 'Email Verification - E-Learning Platform';
        $mail->Body    = "
            <h2>Welcome to our E-Learning Platform</h2>
            <p>Verify your email address using the link below:</p>
            <a href='http://localhost/E_Learning_Platform/Controllers/verify-email.php?token=$verify_token'>Verify Email</a>
        ";
        $mail->AltBody = 'Verify your email address using this link: http://localhost/E_Learning_Platform/Controllers/verify-email.php?token=' . $verify_token;

        $mail->send();
    } catch (Exception $e) {
        header("Location: ../Views/login.php?error=Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}

    // function sendemail_verify($name, $email, $verify_token){
    //     $mail = new PHPMailer(true);
    //     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    //     $mail->isSMTP();                                            //Send using SMTP
    //     $mail->Host       = 'smtp.outlook.com';                     //Set the SMTP server to send through
    //     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    //     $mail->Username   = 'elearningOOPS@outlook.com';                     //SMTP username
    //     $mail->Password   = 'Ad@123456789#!';                               //SMTP password
    //     $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
    //     $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //     //Recipients
    //     $mail->addAddress('joe@example.net', $name);     //Add a recipient
    //     $mail->addAddress($email);               //Name is optional
        

    //     //Content
    //     $mail->isHTML(true);                                  //Set email format to HTML
    //     $mail->Subject = 'Here is the subject';
    //     $mail_template = "
    //         <h2>You have registered in our E-Learning Platform</h2>
    //         <h5>Verify your email address to login with the below given link</h5>
    //         <br/><br/>
    //         <a href='http://localhost/E_Learning_Platform/Controllers/verify-email.php?token=$verify_token'>Click Me</a>
    //     ";
    //     $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    //     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    //     $mail->send();
    //     // echo 'Message has been sent';
    // }



    if(isset($_POST['submit'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $MyRole = $_POST['rule'];

        $verify_token = md5(rand());

        $check_email_query = "SELECT email FROM students WHERE email = '$email'";
        $check_email_query_run = mysqli_query($conn, $check_email_query);
        if(mysqli_num_rows($check_email_query_run) > 0){
            header("Location: ../Views/register.php?error=Email Already Exists");
        }
        $check_email_query = "SELECT email FROM instructors WHERE email = '$email'";
        $check_email_query_run = mysqli_query($conn, $check_email_query);
        if(mysqli_num_rows($check_email_query_run) > 0){
            header("Location: ../Views/register.php?error=Email Already Exists");
        }

        if($password === $confirmPassword){
            if($MyRole === 'student'){
                $query = "INSERT INTO `students`(`FirstName`, `LastName`, `Username`, `Email`, `Password`, `verify_token`)
                 VALUES ('$firstname','$lastname','$username','$email','$password', '$verify_token')";
                $query_run = mysqli_query($conn, $query); 
                if(!$query_run){
                    sendemail_verify("$firstname", "$email", "$verify_token");
                    header("Location: ../Views/register.php?error=Can't register");
                }              
                header("Location:../index.php");
            }else if($MyRole === 'instructor'){
                $query = "INSERT INTO `instructors`(`FirstName`, `LastName`, `Username`, `Email`, `Password`, `verify_token`) 
                VALUES ('$firstname','$lastname','$username','$email','$password', '$verify_token')";
                $query_run = mysqli_query($conn, $query);
                if(!$query_run){
                    header("Location: ../Views/register.php?error=Can't register");

                }        
                header("Location:../index.php");
            }else{
                header("Location: ../Views/register.php?error=Choose Student or Instructor");
            }
        }else{
            $_SESSION['error'] = "Passwords do not match";
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['confirmPassword'] = $confirmPassword;
            $_SESSION['rule'] = $MyRole;

            header("Location: ../Views/register.php");
        }
    }
?>