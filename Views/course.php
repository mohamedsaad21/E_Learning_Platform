<?php
session_start();
include "../config/database.php";

// Check if the 'id' is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    if(!isset($_SESSION['CourseId'])){
        die("Course ID not specified.");
    }
    else{
        $courseId = intval($_SESSION['CourseId']);
    }
}else{
    $courseId = intval($_GET['id']);
}

// Sanitize the input to prevent SQL injection

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
  <link rel="stylesheet" href="../assets/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/student.css">
  <link rel="stylesheet" href="../assets/css/course.css">
</head>

<body>
<header>
        <nav class="navbar">
            <!-- Logo -->
            <a href="home.php" class="logo">E-Learners</a>

            <!-- Links for Desktop -->
            <ul class="nav-links">
                <li><a href="Views/AllCourses.php">All Courses</a></li>
                <li><a href="Views/student.php">Enrolled Courses</a></li>
                <li><a href="#">Certificates</a></li>
                <li><a href="Views/contact.php">Contact Us</a></li>                

                
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === "Admin"):?>
                    <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Content Management
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="Areas/Admin/Courses.php">Courses</a></li>
                        <li><a class="dropdown-item" href="Areas/Admin/Users.php">Users</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <?php endif?>
            </ul>

            <!-- Auth Buttons -->
            <div class="auth-buttons">
                <?php
                        if(isset($_SESSION['user_id'])):?>
                            <a href="#" class="login-btn"> <?php echo $_SESSION['username'] ?> </a>
                            <a href="Controllers/Logout.php" class="register-btn">Log Out</a>
                        <?php else:?>
                            <a href="Views/login.php" class="login-btn">Login</a>
                            <a href="Views/register.php" class="register-btn">Register</a>
                        <?php endif
                ?>
            </div>

            <!-- Hamburger Icon -->
            <i class="fa-solid fa-bars menuIcon"></i>

            <!-- Mobile Menu -->
            <ul class="mobile-menu">
                <li><a href="#">All Courses</a></li>
                <li><a href="#">Enrolled Courses</a></li>
                <li><a href="#">Certificates</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <?php
                        if(isset($_SESSION['user_id'])):?>
                            <li><a href="#" class="login-btn"> <?php echo $_SESSION['username'] ?> </a></li>
                            <li><a href="Controllers/Logout.php" class="register-btn">Log Out</a></li>
                        <?php else:?>
                            <li><a href="Views/login.php" class="login-btn">Login</a></li>
                            <li><a href="Views/register.php" class="register-btn">Register</a></li>
                        <?php endif
                ?>
            </ul>
        </nav>
    </header>

  <form action="../Controllers/EnrollCourseController.php" method="post">
    <div class="course-details">
      <div class="course-image">
        <input type="hidden" name="courseId" value="<?php echo $courseId ?>">
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
        <button type="submit" class="enroll-btn" formaction="../Controllers/EnrollCourseController.php">Enroll Now</button>
        <button type="submit" class="cart-btn" formaction="../Controllers/CartController.php">
          <i class="fas fa-shopping-cart"></i> Add to Cart
        </button>
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

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/all.min.js"></script>
</body>

</html>