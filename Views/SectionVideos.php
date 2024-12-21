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
    <nav class="navbar">
        <a href="../index.php" class="logo">E-Learners</a>
        <ul class="nav-links">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "Instructor"): ?>
                <li><a href="InstructorCourses.php">All Courses</a></li>
            <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === "Student"): ?>
                <li><a href="AllCourses.php">All Courses</a></li>
                <li><a href="../Controllers/EnrollCourseController.php">Enrolled Courses</a></li>
                <li><a href="#">Certificates</a></li>
            <?php endif; ?>
            <li><a href="contact.php">Contact Us</a></li>
        </ul>
        <div class="auth-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="#" class="login-btn"><?= htmlspecialchars($_SESSION['username']) ?></a>
                <a href="../Controllers/Logout.php" class="register-btn">Log Out</a>
            <?php else: ?>
                <a href="login.php" class="login-btn">Login</a>
                <a href="register.php" class="register-btn">Register</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<div class="container">
    <h1 class="text-center">Our Videos</h1>
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
                            <h5 class="card-title"><?= htmlspecialchars($video['Title']) ?></h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; 
        else: ?>
            <p class="text-center">No videos available for this section.</p>
        <?php endif; ?>
    </div>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/all.min.js"></script>
</body>
</html>
