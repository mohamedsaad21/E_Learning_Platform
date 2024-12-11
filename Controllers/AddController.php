<?php
session_start();
include "../config/database.php";

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['Name']);
    $description = mysqli_real_escape_string($conn, $_POST['Descriptions']);
    $categoryId = intval($_POST['categoryId']);
    $price = floatval($_POST['Price']);

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

    $query = "INSERT INTO courses (Title, Description, CategoryId, Price, ImageUrl) 
              VALUES ('$title', '$description', $categoryId, $price, '$imageURL')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['success'] = "Course added successfully.";
        header("Location: ../Views/AllCourses.php");
    } else {
        $_SESSION['error'] = "Failed to add course. Please try again.";
        header("Location: ../Views/addcourses.php");
    }
} else {
    header("Location: ../Views/addcourses.php");
}
?>


