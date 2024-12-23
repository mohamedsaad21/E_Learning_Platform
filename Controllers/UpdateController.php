<?php
session_start();
include "../config/database.php";

if (isset($_POST['submit'])) {
    $id = intval($_POST['courseId']); // Ensure the ID is an integer
    $title = trim(mysqli_real_escape_string($conn, $_POST['Name']));
    $description = trim(mysqli_real_escape_string($conn, $_POST['Descriptions']));
    $categoryId = intval($_POST['categoryId']);
    $price = floatval($_POST['Price']);

    // Check if required fields are empty
    if (empty($title) || empty($description) || empty($price) || empty($categoryId)) {

        $_SESSION['error'] = "All fields are required.";
        $_SESSION['Name'] = $title;
        $_SESSION['Descriptions'] = $description;
        $_SESSION['CategoryId'] = $categoryId;
        $_SESSION['Price'] = $price;
        header("Location: ../Views/updatecourse.php?id=$id");
    }

    // Validate category ID
    $checkCategoryQuery = "SELECT Id FROM categories WHERE Id = $categoryId";
    $checkResult = mysqli_query($conn, $checkCategoryQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        $_SESSION['error'] = "Invalid category ID.";
        header("Location: ../Views/updatecourse.php?id=$id");
    }

    //Handle file upload or retrieve the existing thumbnail
    if (!empty($_FILES['Thumbnail']['name'])) {
        $targetDir = "../assets/imgs/Courses/";
        $fileName = basename($_FILES['Thumbnail']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            header("Location: ../Views/updatecourse.php?id=$id");
        }

        if (!move_uploaded_file($_FILES['Thumbnail']['tmp_name'], $targetFilePath)) {
            $_SESSION['error'] = "Failed to upload the file.";

            header("Location: ../Views/updatecourse.php?id=$id");
        }

        $imageURL = $targetFilePath;
    } else {
        $imageURLQuery = "SELECT ImageUrl FROM courses WHERE Id = $id";
        $imageResult = mysqli_query($conn, $imageURLQuery);

        if ($imageResult && $row = mysqli_fetch_assoc($imageResult)) {
            $imageURL = $row['ImageUrl'];
        } else {
            $_SESSION['error'] = "Thumbnail is required.";
            header("Location: ../Views/updatecourse.php?id=$id");
        }
    }


    // Update course information
    $query = "UPDATE `courses` 
              SET `Title` = '$title', 
                  `Description` = '$description', 
                  `CategoryId` = $categoryId, 
                  `Price` = $price
              WHERE `Id` = $id";
    $result = mysqli_query($conn, $query);
    $lastInsertedId = $id; // Get the auto-incremented ID
    if (isset($_POST['sections']) && is_array($_POST['sections'])) {
        foreach ($_POST['sections'] as $sectionIndex => $sectionData) {
            $sectionTitle = mysqli_real_escape_string($conn, $sectionData['section_title']);

            // Insert Section into courses_sections
            $insertSectionQuery = "INSERT INTO courses_sections (course_id, Title) VALUES ('$lastInsertedId', '$sectionTitle')";
            if (!mysqli_query($conn, $insertSectionQuery)) {
                throw new Exception("Error inserting section: " . mysqli_error($conn));
            }

            $sectionId = mysqli_insert_id($conn); // Get the inserted section ID

            // Process video uploads for the current section
            if (!empty($_FILES['sections']['name'][$sectionIndex]['videos']) && is_array($_FILES['sections']['name'][$sectionIndex]['videos'])) {
                foreach ($_FILES['sections']['name'][$sectionIndex]['videos'] as $videoIndex => $videoName) {
                    if ($_FILES['sections']['error'][$sectionIndex]['videos'][$videoIndex] === UPLOAD_ERR_OK) {
                        $videoTmpName = $_FILES['sections']['tmp_name'][$sectionIndex]['videos'][$videoIndex];
                        $videoPath = '../assets/Videos/' . basename($videoName);

                        if (move_uploaded_file($videoTmpName, $videoPath)) {
                            $videoTitle = "Video " . ($videoIndex + 1); // Customize video title if needed
                            $insertVideoQuery = "INSERT INTO sections_videos (section_id, Title, video_url) VALUES ($sectionId, '$videoTitle', '$videoPath')";
                            if (!mysqli_query($conn, $insertVideoQuery)) {
                                throw new Exception("Error inserting video: " . mysqli_error($conn));
                            }
                        } else {
                            throw new Exception("Failed to upload video: $videoName");
                        }
                    }
                }
            }
        }
    }

    if ($result) {
        $_SESSION['success'] = "Course updated successfully.";
        if ($_SESSION['role'] == "Admin") {
            header("Location: ../Areas/Admin/Courses.php");
        } elseif ($_SESSION['role'] == "Instructor") {
            header("Location: ../Views/CourseSections.php?id=" . urlencode($id));
        }
    } else {
        $_SESSION['error'] = "Failed to update course. Please try again.";
        header("Location: ../Views/updatecourse.php?id=$id");
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../Views/AllCourses.php");
}
