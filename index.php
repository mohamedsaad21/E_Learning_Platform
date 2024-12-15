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
                <?php session_start(); if(isset($_SESSION['role']) && $_SESSION['role'] === "Admin"):?>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                        session_start();
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
    <main>
        <section class="hero">
            <h1>Welcome to <span class="responsive-E-learning"> E-Learners</span></h1>
            <p>Explore a variety of online courses and enhance your skills from the comfort of your home.</p>
            <button class="explore-btn">Explore Courses</button>
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

        <section class="call-to-action">
            <h2>Ready to Get Started?</h2>
            <a href="login.php" class="cta-btn">Join Now</a>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 E-Learners. All rights reserved.</p>
    </footer>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/all.min.js"></script>

</body>

</html>