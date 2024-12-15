<?php
session_start();
include "../config/database.php";
$sql = "SELECT * FROM Courses";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    // Fetch all rows and store them in a session
    $_SESSION['courses'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $_SESSION['courses'] = []; // Empty array if no data found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Home Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/home.css">
</head>
<?php 
    $courses = $_SESSION['courses'] ?? [];
    ?>
<body class="bg-dark text-light">
    <div class="container my-5">
        <h1 class="text-center mb-4">Our Courses</h1>
        <div class="row mb-5">
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === "Admin"):?>
                <a class="text-decoration-none" href="../Controllers/AddController.php">
                    <i class="bi bi-plus-circle"></i> Add New Course
                </a>
            <?php endif?>
        </div>
        <div class="row">
            <!-- Card 1 -->
            <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 text-center">
                <div class="card">
                <img src="../<?= htmlspecialchars($course['ImageUrl']) ?>" class="card-img-top" alt="Course Image">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($course['Title']) ?></h5>
                    <p class="card-text mb-1"><strong>Category:</strong> Programming</p>
                    <p class="card-text mb-3"><strong>Price:</strong> <?= htmlspecialchars($course['Price']) ?></p>
                    <a href="course.php?id=<?= urlencode($course['Id']) ?>" class="btn btn-primary">View Details</a></div>
                    <?php if($_SESSION['role'] === "Admin"):?>
                        <a href="updatecourse.php?id=<?= urlencode($course['Id']) ?>" class="btn btn-primary">Edit</a></div>
                        <a href="deletecourse.php?id=<?= urlencode($course['Id']) ?>" class="btn btn-primary">Delete</a></div>
                    <?php endif?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>