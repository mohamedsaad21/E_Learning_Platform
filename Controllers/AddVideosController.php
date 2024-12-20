<?php
session_start();
include "../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Wrap the operation in a transaction
    mysqli_begin_transaction($conn);

    try {
        // 1. Insert Course
        $name = mysqli_real_escape_string($conn, $_POST['Name']);
        $price = (float)$_POST['Price'];
        $description = mysqli_real_escape_string($conn, $_POST['Descriptions']);
        $categoryId = (int)$_POST['categoryId'];
        $createDate = mysqli_real_escape_string($conn, $_POST['CreateDate']);

        // Handle thumbnail upload
        $thumbnail = '';
        if (isset($_FILES['Thumbnail']) && $_FILES['Thumbnail']['error'] == UPLOAD_ERR_OK) {
            $thumbnail = 'uploads/' . basename($_FILES['Thumbnail']['name']);
            move_uploaded_file($_FILES['Thumbnail']['tmp_name'], $thumbnail);
        }

        $insertCourseQuery = "INSERT INTO courses (Title, Price, Description, CategoryId, CreateDate, Thumbnail) 
                              VALUES ('$name', $price, '$description', $categoryId, '$createDate', '$thumbnail')";
        if (!mysqli_query($conn, $insertCourseQuery)) {
            throw new Exception("Error inserting course: " . mysqli_error($conn));
        }

        $courseId = mysqli_insert_id($conn); // Get the inserted course ID

        // 2. Insert Sections
        if (isset($_POST['sections']) && is_array($_POST['sections'])) {
            foreach ($_POST['sections'] as $sectionIndex => $sectionData) {
                $sectionTitle = mysqli_real_escape_string($conn, $sectionData['section_title']);
                $insertSectionQuery = "INSERT INTO courses_sections (course_id, Title) VALUES ($courseId, '$sectionTitle')";
                if (!mysqli_query($conn, $insertSectionQuery)) {
                    throw new Exception("Error inserting section: " . mysqli_error($conn));
                }

                $sectionId = mysqli_insert_id($conn); // Get the inserted section ID

                // 3. Insert Videos for the Section
                if (isset($_FILES['sections']['name'][$sectionIndex]['videos']) && is_array($_FILES['sections']['name'][$sectionIndex]['videos'])) {
                    foreach ($_FILES['sections']['name'][$sectionIndex]['videos'] as $videoIndex => $videoName) {
                        if ($_FILES['sections']['error'][$sectionIndex]['videos'][$videoIndex] == UPLOAD_ERR_OK) {
                            $videoPath = 'uploads/videos/' . basename($videoName);
                            move_uploaded_file($_FILES['sections']['tmp_name'][$sectionIndex]['videos'][$videoIndex], $videoPath);

                            $videoTitle = "Video " . ($videoIndex + 1); // You can modify this to accept titles dynamically
                            $insertVideoQuery = "INSERT INTO sections_videos (section_id, Title, video_url) VALUES ($sectionId, '$videoTitle', '$videoPath')";
                            if (!mysqli_query($conn, $insertVideoQuery)) {
                                throw new Exception("Error inserting video: " . mysqli_error($conn));
                            }
                        }
                    }
                }
            }
        }

        // Commit the transaction
        mysqli_commit($conn);

        $_SESSION['success'] = "Course, sections, and videos added successfully.";
        header("Location: ../Views/success.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);

        $_SESSION['error'] = $e->getMessage();
        header("Location: ../Views/addcourse.php");
        exit;
    }
}
?>
