<?php
session_start();
include "../config/database.php"; // Include your database configuration file.

if (isset($_POST['delete'])) {
    // Get the course ID from the request.
    $courseId = intval($_POST['courseId']);

    // Prepare the DELETE query to delete the course
    $query = "DELETE FROM courses WHERE id = $courseId";
    $result = mysqli_query($conn, $query);

    // Bind the course ID to the DELETE query

    // Execute the query
    if ($result) {
        $_SESSION['success'] = "Course deleted successfully.";
        if(isset($_SESSION['role']) && $_SESSION['role'] === 'Instructor'){
            header("Location: ../Views/InstructorCourses.php");

        }else if(isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'){
            header("Location: ../Areas/Admin/Courses.php");

        }
    } else {
        $_SESSION['error'] = "Failed to delete the course. Please try again.";
        header("Location: ../Views/deletecourse.php");
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../Views/deletecourse.php");
}