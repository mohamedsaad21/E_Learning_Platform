<?php
session_start();
include "../config/database.php"; // Include your database configuration file.

if (isset($_POST['delete'])) {
    // Get the course ID from the request.
    $courseId = intval($_POST['courseId']);

    // Prepare the DELETE query to delete the course
    $deleteQuery = "DELETE FROM courses WHERE id = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteQuery);
    if (!$deleteStmt) {
        die("Database query failed: " . mysqli_error($conn));
    }

    // Bind the course ID to the DELETE query
    mysqli_stmt_bind_param($deleteStmt, "i", $courseId);

    // Execute the query
    if (mysqli_stmt_execute($deleteStmt)) {
        $_SESSION['success'] = "Course deleted successfully.";
        header("Location: ../Views/AllCourses.php");
    } else {
        $_SESSION['error'] = "Failed to delete the course. Please try again.";
        header("Location: ../Views/deletecourse.php");
    }

    // Close the prepared statement
    mysqli_stmt_close($deleteStmt);
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../Views/deletecourse.php");
}
exit();
