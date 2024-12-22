<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - E-Learners</title>
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/contact.css">
</head>
<?php session_start();?>
<body>
<header>
        <nav class="navbar">
            <!-- Logo -->
            <a href="../index.php" class="logo">E-Learners</a>

            <!-- Links for Desktop -->
            <ul class="nav-links">
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === "Instructor"): ?>
                    <li><a href="InstructorCourses.php">All Courses</a></li>
                <?php endif?>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === "Student"): ?>
                    <li><a href="AllCourses.php">All Courses</a></li>
                <?php endif?>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === "Student"): ?>
                    <li><a href="../Views/EnrolledCourses.php">Enrolled Courses</a></li>
                <?php endif?>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === "Student"): ?>
                    <li><a href="#">Certificates</a></li>
                <?php endif?>
                <li><a href="contact.php">Contact Us</a></li>                


                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === "Admin"):?>
                    <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Content Management
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../Areas/Admin/Courses.php">Courses</a></li>
                        <li><a class="dropdown-item" href="../Areas/Admin/Users.php">Users</a></li>
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

    <main class="contact-page">
        <section class="hero">
            <h1>Contact Us</h1>
            <p>We'd love to hear from you! Fill out the form below or reach us through our social channels.</p>
        </section>

        <section class="contact-form-section">
            <form class="contact-form" action="#" method="POST">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Your Email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Your Message" rows="5" required></textarea>

                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </section>

        <section class="social-links">
            <h2>Connect with us</h2>
            <div class="icons">
                <a href="https://linkedin.com" target="_blank" class="icon-link linkedin"><i class="fab fa-linkedin"></i></a>
                <a href="https://facebook.com" target="_blank" class="icon-link facebook"><i class="fab fa-facebook"></i></a>
                <a href="https://whatsapp.com" target="_blank" class="icon-link whatsapp"><i class="fab fa-whatsapp"></i></a>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 E-Learners. All rights reserved.</p>
    </footer>
</body>

</html>