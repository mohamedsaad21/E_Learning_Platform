<?php
session_start();
include "../config/database.php";

if (isset($_POST['submit'])) {
    $id = intval($_POST['courseId']);
    $title = trim(mysqli_real_escape_string($conn, $_POST['Name']));
    $description = trim(mysqli_real_escape_string($conn, $_POST['Descriptions']));
    $categoryId = intval($_POST['categoryId']);
    $price = floatval($_POST['Price']);

    if (empty($title) || empty($description) || empty($price) || empty($categoryId)) {
        $_SESSION['error'] = "All fields are required.";
        $_SESSION['Name'] = $title;
        $_SESSION['Descriptions'] = $description;
        $_SESSION['CategoryId'] = $categoryId;
        $_SESSION['Price'] = $price;
        header("Location: ../Views/updatecourse.php");
        exit();
    }

    $checkCategoryQuery = "SELECT Id FROM categories WHERE Id = $categoryId";
    $checkResult = mysqli_query($conn, $checkCategoryQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        $_SESSION['error'] = "Invalid category ID.";
        header("Location: ../Views/updatecourse.php");
        exit();
    }

    if (!empty($_FILES['Thumbnail']['name'])) {
        $targetDir = "../assets/imgs/Courses/";
        $fileName = basename($_FILES['Thumbnail']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            header("Location: ../Views/updatecourse.php");
            exit();
        }

        if (!move_uploaded_file($_FILES['Thumbnail']['tmp_name'], $targetFilePath)) {
            $_SESSION['error'] = "Failed to upload the file.";
            header("Location: ../Views/updatecourse.php");
            exit();
        }

        $imageURL = $targetFilePath;
    } else {
        $imageURLQuery = "SELECT ImageUrl FROM courses WHERE Id = $id";
        $imageResult = mysqli_query($conn, $imageURLQuery);

        if ($imageResult && $row = mysqli_fetch_assoc($imageResult)) {
            $imageURL = $row['ImageUrl'];
        } else {
            $_SESSION['error'] = "Thumbnail is required.";
            header("Location: ../Views/updatecourse.php");
            exit();
        }
    }

    $query = "UPDATE `courses` 
              SET `Title` = '$title', 
                  `Description` = '$description', 
                  `CategoryId` = $categoryId, 
                  `Price` = $price, 
                  `ImageUrl` = '$imageURL' 
              WHERE `Id` = $id";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['success'] = "Course updated successfully.";
        header("Location: ../Views/AllCourses.php");
    } else {
        $_SESSION['error'] = "Failed to update course. Please try again.";
        header("Location: ../Views/updatecourse.php");
    }
} else {
    header("Location: ../Views/updatecourse.php");
}
?>
