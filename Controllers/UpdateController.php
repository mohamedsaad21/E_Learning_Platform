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

    if ($result) {
        $_SESSION['success'] = "Course updated successfully.";
        if($_SESSION['role'] == "Admin"){
            header("Location: ../Areas/Admin/Courses.php");
        }
    } else {
        $_SESSION['error'] = "Failed to update course. Please try again.";
        header("Location: ../Views/updatecourse.php?id=$id");
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../Views/AllCourses.php");
}
?>
