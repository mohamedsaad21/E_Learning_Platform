<?php
session_start();
include "../config/database.php";

$studentId = $_SESSION['user_id'];
$courseId = $_POST['courseId'];
$title=$_POST['Title'];

$checkQuery = "SELECT * FROM `my_cart` WHERE `StudentId` = $studentId AND `CourseId` = $courseId";
$checkResult = mysqli_query($conn, $checkQuery);

if (mysqli_num_rows($checkResult) > 0) {
    $_SESSION['error'] = "Course already exists in your cart.";
    header("Location: ../Views/AllCourses.php");
} else {
    $sql = "INSERT INTO `my_cart`(`StudentId`, `CourseId`) VALUES ($studentId, $courseId)";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['success'] = "You Enrolled Course Successfully.";
        header("Location: ../Views/cart_view.php");
    } else {
        $_SESSION['error'] = "Failed to enroll course. Please try again.";
        header("Location: ../Views/AllCourses.php");
    }
}
?>