<?php
session_start();
include "../config/database.php";

// Check if the 'id' is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Course ID not specified.");
}

// Sanitize the input to prevent SQL injection
$courseId = intval($_GET['id']);

// Fetch course details from the database using a prepared statement
$sql = "SELECT * FROM `Courses` WHERE `id` = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $courseId); // Bind the ID parameter as an integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the course exists
    if ($result && mysqli_num_rows($result) > 0) {
        $course = mysqli_fetch_assoc($result);
    } else {
        die("Course not found.");
    }

    mysqli_stmt_close($stmt);
} else {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($course['Title']) ?> - Course Details</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/course.css">
  <link rel="stylesheet" href="../assets/css/student.css">
</head>

<body>
  <header class="header">
    <div class="header-content">
      <h1>Welcome, <span class="studentName"><?= htmlspecialchars($_SESSION['Name'] ?? "Guest") ?></span></h1>
    </div>
  </header>

  <form action="../Controllers/EnrollCourseController.php" method="post">
    <div class="course-details">
      <div class="course-image">
        <img src="<?= htmlspecialchars('../'.$course['ImageUrl'] ?: '../assets/imgs/Courses/default-course.jpg') ?>" 
            alt="<?= htmlspecialchars($course['Title']) ?> Image">
      </div>
      <div class="course-info">
        <h1><?= htmlspecialchars($course['Title']) ?></h1>
        <div class="course-price">
          <span class="current-price">$<?= htmlspecialchars($course['Price']) ?></span>
        </div>
        <p class="course-description">
          <?= htmlspecialchars($course['Description']) ?>
        </p>
        <button type="submit" class="enroll-btn">Enroll Now</button>
      </div>
    </div>
  </form>

  <footer class="footer">
    <div class="container">
      <div class="footer-content d-flex justify-content-evenly">
        <span><b>E-Learners</b></span>
        <span>&copy; 2024 E-Learners. All rights reserved.</span>
      </div>
    </div>
  </footer>
</body>

</html>
