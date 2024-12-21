<?php
session_start();
include "../config/database.php";

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['Name']);
    $description = mysqli_real_escape_string($conn, $_POST['Descriptions']);
    $categoryId = intval($_POST['categoryId']);
    $price = floatval($_POST['Price']);
    $InstructorId = $_SESSION['user_id'];

    if (!empty($_FILES['Thumbnail']['name'])) {
        $targetDir = "../assets/imgs/Courses/";
        $fileName = basename($_FILES['Thumbnail']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['error'] = "Invalid file type.";
            header("Location: ../Views/addcourses.php");
            exit();
        }

        if (!move_uploaded_file($_FILES['Thumbnail']['tmp_name'], $targetFilePath)) {
            $_SESSION['error'] = "Failed to upload the file.";
            header("Location: ../Views/addcourses.php");
            exit();
        }

        $imageURL = $targetFilePath;
    } else {
        $_SESSION['error'] = "Thumbnail is required.";
        header("Location: ../Views/addcourses.php");
        exit();
    }

    if (empty($title) || empty($description) || empty($price)) {
        $_SESSION['error'] = "All fields are required.";
        $_SESSION['Name'] = $title;
        $_SESSION['Descriptions'] = $description;
        $_SESSION['CategoryId'] = $categoryId;
        $_SESSION['Price'] = $price;
        header("Location: ../Views/addcourses.php");
        exit();
    }

    $checkCategoryQuery = "SELECT Id FROM categories WHERE Id = $categoryId";
    $checkResult = mysqli_query($conn, $checkCategoryQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        $_SESSION['error'] = "Invalid category ID.";
        header("Location: ../Views/addcourses.php");
        exit();
    }
    $query = "INSERT INTO courses (Title, Description, CategoryId, Price, ImageUrl, InstructorId) 
              VALUES ('$title', '$description', $categoryId, $price, '$imageURL', '$InstructorId')";
    $result = mysqli_query($conn, $query);
    $lastInsertedId = mysqli_insert_id($conn); // Get the auto-incremented ID
    //Add Sections And Videos For Each Course

    if (isset($_POST['sections']) && is_array($_POST['sections'])) {
        foreach ($_POST['sections'] as $sectionIndex => $sectionData) {
            $sectionTitle = mysqli_real_escape_string($conn, $sectionData['section_title']);
            $insertSectionQuery = "INSERT INTO courses_sections (course_id, Title) VALUES ('$lastInsertedId', '$sectionTitle')";
            if (!mysqli_query($conn, $insertSectionQuery)) {
                throw new Exception("Error inserting section: " . mysqli_error($conn));
            }

            $sectionId = mysqli_insert_id($conn); // Get the inserted section ID

            // 3. Insert Videos for the Section
            if (isset($_FILES['sections']['name'][$sectionIndex]['videos']) && is_array($_FILES['sections']['name'][$sectionIndex]['videos'])) {
                foreach ($_FILES['sections']['name'][$sectionIndex]['videos'] as $videoIndex => $videoName) {
                    if ($_FILES['sections']['error'][$sectionIndex]['videos'][$videoIndex] == UPLOAD_ERR_OK) {
                        $videoPath = '../assets/Videos/' . basename($videoName);
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

    if ($result) {
        $_SESSION['success'] = "Course added successfully.";
        header("Location: ../Views/InstructorCourses.php");
    } else {
        $_SESSION['error'] = "Failed to add course. Please try again.";
        header("Location: ../Views/addcourses.php");
    }
} else {
    header("Location: ../Views/addcourses.php");
}
?>