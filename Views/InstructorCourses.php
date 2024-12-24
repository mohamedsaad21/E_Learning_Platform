<?php
session_start();
include "../config/database.php";

// Check if the user is an instructor
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "Instructor") {
    header("Location: ../AccessDenied.php");
    exit();
}

// Fetch instructor ID from session
$Instructor_id = $_SESSION['user_id'];

// Prepare and execute the query to fetch courses securely
$query = "SELECT courses.*, categories.Name as CategoryName 
          FROM Courses 
          INNER JOIN categories ON categories.Id = courses.CategoryId 
          WHERE InstructorId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $Instructor_id);
$stmt->execute();
$result = $stmt->get_result();

// Store courses in session
if ($result && $result->num_rows > 0) {
    $_SESSION['courses'] = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $_SESSION['courses'] = [];
}

$courses = $_SESSION['courses'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard</title>
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/allcourses.css">
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a href="../index.php" class="logo navbar-brand">E-Learners</a>
            <button class="navbar-toggler menuIcon" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="nav-links navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="InstructorCourses.php">Your Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                </ul>
                <div class="auth-buttons d-flex">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="#" class="login-btn me-2"><?= htmlspecialchars($_SESSION['username']) ?></a>
                        <a href="../Controllers/Logout.php" class="register-btn">Log Out</a>
                    <?php else: ?>
                        <a href="login.php" class="login-btn me-2">Login</a>
                        <a href="register.php" class="register-btn">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="container">
    <h1 class="text-center">Your Courses</h1>
    <div class="row mb-5">
        <a class="text-decoration-none" href="../Controllers/AddController.php">
            <i class="bi bi-plus-circle"></i> Add New Course
        </a>
    </div>
    <div class="row">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-5 text-center">
                    <div class="card mb-5 border border-dark-subtle">
                        <img src="../<?= htmlspecialchars(str_replace('../', '', $course['ImageUrl'])) ?>" alt="CourseImage" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($course['Title']) ?></h5>
                            <p class="card-text mb-1"><strong>Category:</strong> <?= htmlspecialchars($course['CategoryName']) ?></p>
                            <p class="card-text mb-3"><strong>Price:</strong> <?= htmlspecialchars($course['Price']) ?></p>
                            <a href="../Areas/Instructor/InstructorDashboard.php?id=<?= urlencode($course['Id']) ?>" class="btn btn-primary">View Details</a>
                        </div>
                        <a href="updatecourse.php?id=<?= urlencode($course['Id']) ?>" class="w-25 m-auto mb-1 btn btn-primary">Edit</a>
                        <a href="deletecourse.php?id=<?= urlencode($course['Id']) ?>" class="w-25 m-auto mb-1 btn btn-danger">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No courses found. Add a new course to get started!</p>
        <?php endif; ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="footer-content d-flex justify-content-evenly">
            <span>&copy; 2024 E-Learners. All rights reserved.</span>
        </div>
    </div>
</footer>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/all.min.js"></script>
</body>

</html>