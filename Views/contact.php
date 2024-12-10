<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - E-Learners</title>
    <link rel="stylesheet" href="../assets/css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="home.php" class="logo">E-Learners</a>
            <ul class="nav-links">
                <li><a href="#">All Courses</a></li>
                <li><a href="#">Enrolled Courses</a></li>
                <li><a href="#">Certificates</a></li>
                <li><a href="#">Contact Us</a></li>
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
