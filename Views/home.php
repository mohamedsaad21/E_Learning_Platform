<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/home.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <!-- Logo -->
            <a href="home.php" class="logo">E-Learners</a>

            <!-- Links for Desktop -->
            <ul class="nav-links">
                <li><a href="#">All Courses</a></li>
                <li><a href="#">Enrolled Courses</a></li>
                <li><a href="#">Certificates</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>

            <!-- Auth Buttons -->
            <div class="auth-buttons">
                <a href="login.php" class="login-btn">Login</a>
                <a href="register.php" class="register-btn">Register</a>
            </div>

            <!-- Hamburger Icon -->
            <i class="fa-solid fa-bars menuIcon"></i>

            <!-- Mobile Menu -->
            <ul class="mobile-menu">
                <li><a href="#">All Courses</a></li>
                <li><a href="#">Enrolled Courses</a></li>
                <li><a href="#">Certificates</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="login.php" class="login-btn">Login</a></li>
                <li><a href="register.php" class="register-btn">Register</a></li>
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

</body>

</html>