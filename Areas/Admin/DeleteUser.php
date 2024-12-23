<?php
    session_start();
    include "../../config/database.php";
    if (isset($_GET['id'])) {
        $UserId = $_GET['id'];
        $sql = "DELETE FROM users WHERE Id = $UserId";
        $result = mysqli_query($conn, $sql);
        if ($result) {
                $_SESSION['success'] = "Student deleted successfully.";
                header("Location: Users.php");
            }
            else {
                $_SESSION['error'] = "Failed to delete the student. Please try again.";
            }
    }else {
        $_SESSION['error'] = "Invalid request.";
    }
?>