<?php
// Database connection
include "../config/database.php";

// Fetch data with JOIN to get course names and student names
$query = "
    SELECT 
        my_cart.CourseId,
        my_cart.StudentId,
        courses.Title AS CourseName,
        CONCAT(users.FirstName, ' ', users.LastName) AS StudentName
    FROM 
        my_cart
    JOIN 
        courses ON my_cart.CourseId = courses.Id
    JOIN 
        users ON my_cart.StudentId = users.Id
";
$result = mysqli_query($conn, $query);

// Initialize an empty array to store data
$cartItems = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cartItems[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart View</title>
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/CartStyle.css">
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
            aria-label="Toggle navigation"
        >
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Centered Links -->
            <ul class="nav-links navbar-nav mx-auto">
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === "Instructor"): ?>
                <li class="nav-item"><a class="nav-link" href="InstructorCourses.php">Your Courses</a></li>
            <?php endif; ?>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === "Student"): ?>
                <li class="nav-item"><a class="nav-link" href="AllCourses.php">All Courses</a></li>
                <li class="nav-item"><a class="nav-link" href="EnrolledCourses.php">Enrolled Courses</a></li>
            <?php endif; ?>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
            </ul>

            <!-- Auth Buttons -->
            <div class="auth-buttons d-flex">
            <?php if(isset($_SESSION['user_id'])): ?>
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

<div class="container">
    <h3>Cart Items</h3>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Student Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($cartItems)): ?>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['CourseName']) ?></td>
                        <td><?= htmlspecialchars($item['StudentName']) ?></td>
                        <td>
                            <!-- Form to delete course using POST -->
                            <form action="../Controllers/delete_cart.php" method="POST">
                                <input type="hidden" name="courseId" value="<?= $item['CourseId'] ?>">
                                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No items in the cart.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/all.min.js"></script>
</body>
</html>