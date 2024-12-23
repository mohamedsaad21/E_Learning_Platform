<?php
session_start();
include "../config/database.php";

// Check if the 'id' is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    if (!isset($_SESSION['CourseId'])) {
        die("Course ID not specified.");
    } else {
        $courseId = intval($_SESSION['CourseId']);
    }
} else {
    $courseId = intval($_GET['id']);
}

// Sanitize the input to prevent SQL injection

// Fetch course details from the database using a prepared statement
$sql = "SELECT * FROM `courses` WHERE `id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $courseId);
$stmt->execute();
$result = $stmt->get_result();

// Check if the course exists
if ($result && $result->num_rows > 0) {
    $course = $result->fetch_assoc();
} else {
    die("Course not found.");
}
?>
<?php $_SESSION['CourseId'] = $courseId ?>
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
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <!-- Logo -->
                <a href="../index.php" class="logo navbar-brand">E-Learners</a>

                <!-- Hamburger Icon -->
                <button
                    class="navbar-toggler menuIcon"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarContent"
                    aria-controls="navbarContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <!-- Navbar Content -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <!-- Centered Links -->
                    <ul class="nav-links navbar-nav mx-auto">
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "Instructor"): ?>
                            <li class="nav-item"><a class="nav-link" href="InstructorCourses.php">Your Courses</a></li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "Student"): ?>
                            <li class="nav-item"><a class="nav-link" href="AllCourses.php">All Courses</a></li>
                            <li class="nav-item"><a class="nav-link" href="EnrolledCourses.php">Enrolled Courses</a></li>
                            <li class="nav-item"><a class="nav-link" href="cart_view.php">Go to Cart</a></li>

                        <?php endif; ?>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                    </ul>

                    <!-- Auth Buttons -->
                    <div class="auth-buttons d-flex">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="#" class="login-btn me-2"><?php echo $_SESSION['username']; ?></a>
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

    <form action="../Controllers/EnrollCourseController.php" method="post">
        <div class="course-details">
            <div class="course-image">
                <input type="hidden" name="courseId" value="<?= $courseId ?>">
                <img src="../<?= htmlspecialchars(!empty($course['ImageUrl']) ? str_replace('../', '', $course['ImageUrl']) : 'assets/imgs/Courses/default-course.jpg') ?>"
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
                <button type="submit" class="enroll-btn" formaction="../Controllers/checkout.php">Enroll Now</button>
                <button type="submit" class="cart-btn" formaction="../Controllers/CartController.php">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>
            </div>
        </div>
    </form>

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