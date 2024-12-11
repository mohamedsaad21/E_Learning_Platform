<?php session_start();?>
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
      <!-- Login Form -->
      <div class="forms">
        <form action="../Controllers/LoginController.php" method="post" class="form" id="loginForm">
        <?php if(isset($_SESSION['success'])){ ?>
            <div class="alert alert-success" role="alert">
              <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
            </div>
          <?php } ?>
          <h2 class="formType">Login</h2>
          <?php if(isset($_SESSION['error'])){ ?>
            <div class="alert alert-danger" role="alert">
              <p class="error"><?php echo $_SESSION['error'] ?></p>
            </div>
          <?php } ?>
          <div class="typeContainer">
            <input type="radio" name="rule" class="userType" id="student" value="student">
            <label for="student">Student</label>
            <input type="radio" name="rule" class="userType" id="instructor" value="instructor">
            <label for="instructor">Instructor</label>
          </div>
          <input type="email" id="loginEmail" name="email" required placeholder="Enter Email" value="<?php 
          if(isset($_SESSION['email'])) echo $_SESSION['email'];
          unset($_SESSION['email']); 
          ?>">
          <input type="password" id="loginPassword" name="password" required minlength="8" placeholder="Enter Password" value="<?php 
          if(isset($_SESSION['password'])) echo $_SESSION['password'];
          unset($_SESSION['password']); 
          ?>">
          <input type="submit" value="Login" name="login">
          <p>Don't have an account? <a href="register.php">Register Now</a></p>
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