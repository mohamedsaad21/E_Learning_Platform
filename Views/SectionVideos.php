<?php
session_start();
include "../config/database.php";

// Validate and sanitize the section ID
$sectionId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch videos for the given section
$sql = "SELECT sections_videos.* FROM courses_sections 
        INNER JOIN sections_videos ON courses_sections.Id = sections_videos.section_id 
        WHERE sections_videos.section_id = $sectionId";
$result = mysqli_query($conn, $sql);

// Check if videos exist for this section
if ($result && mysqli_num_rows($result) > 0) {
    $_SESSION['videos'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $_SESSION['videos'] = []; // No videos found
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videos Home Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/allvideos.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <!-- Logo -->
                <a href="index.php" class="logo navbar-brand">E-Learners</a>

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
                            <li class="nav-item"><a class="nav-link" href="Views/InstructorCourses.php">Your Courses</a></li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "Student"): ?>
                            <li class="nav-item"><a class="nav-link" href="Views/AllCourses.php">All Courses</a></li>
                            <li class="nav-item"><a class="nav-link" href="Views/EnrolledCourses.php">Enrolled Courses</a></li>
                            <li class="nav-item"><a class="nav-link" href="cart_view.php">Go to Cart</a></li>

                        <?php endif; ?>
                        <li class="nav-item"><a class="nav-link" href="Views/contact.php">Contact Us</a></li>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "Admin"): ?>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Content Management
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="Areas/Admin/Courses.php">Courses</a></li>
                                    <li><a class="dropdown-item" href="Areas/Admin/Users.php">Users</a></li>
                                </ul>
                            </li>
                        <?php endif ?>
                    </ul>

                    <!-- Auth Buttons -->
                    <div class="auth-buttons d-flex">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="#" class="login-btn me-2"><?php echo $_SESSION['username']; ?></a>
                            <a href="Controllers/Logout.php" class="register-btn">Log Out</a>
                        <?php else: ?>
                            <a href="Views/login.php" class="login-btn me-2">Login</a>
                            <a href="Views/register.php" class="register-btn">Register</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1 class="text-center my-3 text-primary">Our Videos</h1>
        <div class="row">
            <?php
            $videos = $_SESSION['videos'] ?? [];
            if (!empty($videos)):
                foreach ($videos as $video): ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card">
                            <video width="100%" controls>
                                <source src="../<?= htmlspecialchars(str_replace('../', '', $video['video_url'])) ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        <?= htmlspecialchars($video['Title']) ?>

                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered square-modal">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                        <?= htmlspecialchars($video['Title']) ?>
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <video controls>
                                                        <source src="../<?= htmlspecialchars(str_replace('../', '', $video['video_url'])) ?>" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            else: ?>
                <p class="text-center">No videos available for this section.</p>
            <?php endif; ?>
        </div>
    </div>







    <!-- video modal -->
    <!-- Button trigger modal -->




    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/all.min.js"></script>
</body>

</html>