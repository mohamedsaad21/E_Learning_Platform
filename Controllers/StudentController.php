<?php
    include "../config/database.php";
    session_start();

    // Fetch courses from the database
    $sql = "SELECT * FROM `Courses`";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Store courses in session
        $_SESSION['courses'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $_SESSION['courses'] = []; // Empty array if no courses found
    }

    header("Location: ../Views/student.php");
    exit;
?>
