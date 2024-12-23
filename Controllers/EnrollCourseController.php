<?php
    session_start();
    include "../config/database.php";
    $studentId = $_SESSION['user_id'];
    $currentDate = date("Y-m-d");
    if(!isset($_POST['courseId'])){
        $courseId = $_SESSION['CourseId'];
    }else{
        $courseId = $_POST['courseId'];
    }
    $sql = "INSERT INTO `students_courses`(`StudentId`, `CourseId`) VALUES ($studentId,$courseId)";
    $result = mysqli_query($conn, $sql);
    $sql = "INSERT INTO `payment`(`UserId`, `CourseId`, `PaymentDate`, `Status`) VALUES ($studentId,$courseId, CURRENT_DATE, 'Paid')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['success'] = "You Enrolled Course Successfully.";
        header("Location: ../Views/EnrolledCourses.php");
    } else {
        $_SESSION['error'] = "Failed to enroll course. Please try again.";
        header("Location: ../Views/AllCourses.php");
    }
?>