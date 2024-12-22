<?php
session_start();
include "../config/database.php"; // Include your database configuration file.

if (isset($_POST['delete'])) {
    // Get the course ID from the POST request.
    $courseId = intval($_POST['courseId']);

    // Prepare the DELETE query to delete the course from the cart
    $query = "DELETE FROM my_cart WHERE CourseId = $courseId"; 
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        $_SESSION['success'] = "Course removed from the cart successfully.";
        header("Location: ../Views/cart_view.php"); // Redirect back to the cart view page
    } else {
        $_SESSION['error'] = "Failed to remove the course from the cart. Please try again.";
        header("Location: ../Views/cart_view.php"); // Redirect back to the cart view page
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../Views/cart_view.php"); // Redirect back to the cart view page
}
?>