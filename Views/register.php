<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="../assets/css/style.css">
  <title>E-Learners</title>
</head>
<body>
  <h1>E-Learners</h1>
  <div class="container">
    <!-- Registration Form -->
    <div class="forms">
      <form action="../Controllers/RegisterController.php" class="form" method="post" id="registerForm">
        <h2 class="formType">Register</h2>
        <?php if(isset($_GET['error'])){ ?>
          <div class="alert alert-danger" role="alert">
            <p class="error"><?php echo $_GET['error'] ?></p>
          </div>
        <?php } ?>
        <div class="typeContainer">
          <input type="radio" name="rule" class="userType" id="student" value="student">
          <label for="student">Student</label>
          <input type="radio" name="rule" class="userType" id="instructor" value="instructor">
          <label for="instructor">Instructor</label>
        </div>
        <input type="text" id="firstname" name="firstname" required placeholder="First Name">
        <input type="text" id="lastname" name="lastname" required placeholder="Last Name">
        <input type="text" id="username" name="username" required placeholder="Username">
        <input type="email" id="email" name="email" required placeholder="Email">
        <input type="password" id="password" name="password" required minlength="8" placeholder="password">
        <input type="password" id="confirmPassword" name="confirmPassword" required minlength="8"
          placeholder="Confirm password">
        <input type="submit" value="Register">
        <p>Already have an account? <a href="login.php">Login Now</a></p>
      </form>
    </div>
    <!-- Image Section -->
    <div class="image">
      <img src="../assets/imgs/login and regiser.png" alt="Illustration">
    </div>
  </div>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>