<?php
session_start();
include "../config/database.php";
$UserId = $_SESSION['user_id'];
$sql = "SELECT * FROM courses INNER JOIN students_courses ON courses.Id = students_courses.CourseId INNER JOIN users ON users.Id = students_courses.StudentId WHERE users.Id = $UserId";
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
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/allcourses.css">
</head>
<?php 
    $courses = $_SESSION['courses'] ?? [];
    ?>
<body>

<header>
        <nav class="navbar">
            <!-- Logo -->
            <a href="../index.php" class="logo">E-Learners</a>

            <!-- Links for Desktop -->
            <ul class="nav-links">
                <li><a href="AllCourses.php">All Courses</a></li>
                <li><a href="student.php">Enrolled Courses</a></li>
                <li><a href="#">Certificates</a></li>
                <li><a href="contact.php">Contact Us</a></li>                

                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === "Admin"):?>
                    <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Content Management
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../Areas/Admin/Courses.php">Courses</a></li>
                        <li><a class="dropdown-item" href="../Areas/Admin/Users.php">Users</a></li>
                    </ul>
                </li>
                <?php endif?>
            </ul>

            <!-- Auth Buttons -->
            <div class="auth-buttons">
                <?php
                        if(isset($_SESSION['user_id'])):?>
                            <a href="#" class="login-btn"> <?php echo $_SESSION['username'] ?> </a>
                            <a href="../Controllers/Logout.php" class="register-btn">Log Out</a>
                        <?php else:?>
                            <a href="login.php" class="login-btn">Login</a>
                            <a href="register.php" class="register-btn">Register</a>
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
                
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === "Admin"):?>
                    <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Content Management
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../Areas/Admin/Courses.php">Courses</a></li>
                        <li><a class="dropdown-item" href="../Areas/Admin/Users.php">Users</a></li>
                    </ul>
                </li>
                <?php endif?>
                
                <?php
                        if(isset($_SESSION['user_id'])):?>
                            <li><a href="#" class="login-btn"> <?php echo $_SESSION['username'] ?> </a></li>
                            <li><a href="../Controllers/Logout.php" class="register-btn">Log Out</a></li>
                        <?php else:?>
                            <li><a href="login.php" class="login-btn">Login</a></li>
                            <li><a href="register.php" class="register-btn">Register</a></li>
                        <?php endif
                ?>


            </ul>
        </nav>
    </header>

    <div class="container">
        <h1 class="text-center">My Courses</h1>
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
                <div class="col-lg-4 col-md-6 col-sm-12 mb-5 text-center">
                    <div class="card mb-5 border border-dark-subtle">
                    <img src="../<?= htmlspecialchars(str_replace('../', '', $course['ImageUrl'])) ?>" alt="Course Image">  
                  <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($course['Title']) ?></h5>
                        <p class="card-text mb-1"><strong>Category:</strong> Programming</p>
                        <p class="card-text mb-3"><strong>Price:</strong> <?= htmlspecialchars($course['Price']) ?></p>
                        <a href="course.php?id=<?= urlencode($course['Id']) ?>" class="btn btn-primary">View Details</a>
                    </div>
                        <?php if($_SESSION['role'] === "Admin"):?>
                            <a href="updatecourse.php?id=<?= urlencode($course['Id']) ?>" class=" w-25 m-auto mb-1 btn btn-primary">Edit</a>
                            <a href="deletecourse.php?id=<?= urlencode($course['Id']) ?>" class=" w-25 m-auto mb-1 btn btn-primary">Delete</a>
                            <?php endif?>
                </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="footer-content d-flex justify-content-evenly">
                <span><b>E-Learners</b></span>
                <span>&copy; 2024 E-Learners. All rights reserved.</span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/all.min.js"></script>
</body>
</html>