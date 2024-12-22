<?php
    session_start();
    include "../config/database.php";
    if($_SESSION['role'] != "Student"){
        header("Location: ../AccessDenied.php");
    }
    $StudentId = $_SESSION['user_id'];
    $CourseId = intval($_GET['id']);
    $sql = "SELECT * FROM students_courses WHERE CourseId = $CourseId AND StudentId = $StudentId";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch all rows and store them in a session
        $_SESSION['courses'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $id = $CourseId; // Replace this with your actual ID
        header("Location: ../Views/CourseSections.php?id=" . urlencode($id));
        exit();
    } else {
        $_SESSION['courses'] = []; // Empty array if no data found
        $_SESSION['CourseId'] = $CourseId;
        header("Location: ../Views/course.php");

    }
    exit;
?>
