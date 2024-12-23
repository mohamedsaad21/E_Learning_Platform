<?php
session_start();
include "../../config/database.php"; // Include your database configuration file.

if (isset($_GET['id'])) {
    // Get the course ID from the request.
    $StudentId = intval($_GET['id']);

    // Prepare the DELETE query to delete the course
    $CourseId = $_SESSION['CourseId'];
    $query = "DELETE FROM students_courses WHERE StudentId = $StudentId AND CourseId = $CourseId";
    $result = mysqli_query($conn, $query);
    // Bind the course ID to the DELETE query

    // Execute the query
    if ($result) {
        $_SESSION['success'] = "Student deleted successfully.";
        if(isset($_SESSION['role']) && $_SESSION['role'] === 'Instructor'){
            header("Location: InstructorDashboard.php?id=$CourseId");

        }
        } else {
            $_SESSION['error'] = "Failed to delete the student. Please try again.";
            header("Location: InstructorDashboard.php");
        }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: InstructorDashboard.php");
}