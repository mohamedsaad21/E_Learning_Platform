<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/home.css">
</head>
<?php session_start(); ?>

<body>


    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <!-- Logo -->
                <a href="index.php" class="logo">E-Learners</a>

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
                            <li class="nav-item"><a class="nav-link" href="Views/cart_view.php">Go to Cart</a></li>

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

    <main>
        <section class="hero">
            <h1>Welcome to <span class="responsive-E-learning"> E-Learners</span></h1>
            <p>Explore a variety of online courses and enhance your skills from the comfort of your home.</p>





            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "Instructor"): ?>
                <a class="explore-btn btn btn-primary" href="Views/InstructorCourses.php">Explore Courses</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "Student"): ?>
                <a class="explore-btn btn btn-primary" href="Views/AllCourses.php">Explore Courses</a>
            <?php endif; ?>



        </section>

        <section class="features">
            <h2>Why Choose E-Learners?</h2>
            <div class="feature-cards">
                <div class="card">
                    <h3>Wide Range of Courses</h3>
                    <p>Discover courses on various topics from technology to arts.</p>
                </div>
                <div class="card">
                    <h3>Expert Instructors</h3>
                    <p>Learn from industry experts and enhance your learning experience.</p>
                </div>
                <div class="card">
                    <h3>Get Certified</h3>
                    <p>Earn certificates to showcase your achievements and skills.</p>
                </div>
            </div>
        </section>


        <?php if (!isset($_SESSION['user_id'])): ?>
            <section class="call-to-action">
                <h2>Ready to Get Started?</h2>
                <a href="Views/login.php" class="cta-btn">Join Now</a>
            </section>
        <?php else: ?>
            <section class="call-to-action opacity-0">
                <h2>Ready to Get Started?</h2>
                <a href="Views/login.php" class="cta-btn">Join Now</a>
            </section>
        <?php endif;?>
        <?php if (!isset($_SESSION['user_id'])): ?>
        <section class="call-to-action">
            <h2>Ready to Get Started?</h2>
            <a href="Views/login.php" class="cta-btn">Join Now</a>
        </section>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content d-flex justify-content-evenly">
                <span>&copy; 2024 E-Learners. All rights reserved.</span>
            </div>
        </div>
    </footer>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/all.min.js"></script>

</body>

</html>