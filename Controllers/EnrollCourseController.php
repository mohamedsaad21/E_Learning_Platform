<?php
    session_start();
    include "../config/database.php";
    $studentId = $_SESSION['Id'];
    $courseId = $_POST['courseId'];
    $sql = "INSERT INTO `students_courses`(`StudentId`, `CourseId`) VALUES ('$studentId','$courseId')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['success'] = "You Enrolled Course Successfully.";
        header("Location: ../Views/AllCourses.php");
    } else {
        $_SESSION['error'] = "Failed to enroll course. Please try again.";
        header("Location: ../Views/addcourses.php");
    }
?>