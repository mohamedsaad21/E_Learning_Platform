<?php 
session_start();

// Check if the user is logged in and session contains necessary data
if (!isset($_SESSION['Name'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

$courses = $_SESSION['courses'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Page</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/student.css">
</head>
<body>
  <!-- Header Section -->
  <header class="header">
    <div class="header-content">
      <h1>Welcome <span class="studentName"><?= htmlspecialchars($_SESSION['Name']) ?></span></h1>
      <div class="dropdown">
        <button class="dropbtn">Menu</button>
        <div class="dropdown-content">
          <a href="#enrolled-courses">Enrolled Courses</a>
          <a href="#certificates">Certificates</a>
          <a href="#available-courses">Available Courses</a>
        </div>
      </div>
    </div>
  </header>

  <!-- Enrolled Courses Section -->
  <section id="enrolled-courses" class="section">
    <h2>Enrolled Courses</h2>
    <div class="container text-center">
      <div class="row">
        <?php if (!empty($courses)): ?>
          <?php foreach ($courses as $course): ?>
            <div class="col-4 mb-5">
              <div class="card">
              <img src="<?= htmlspecialchars('../'.$course['ImageUrl'] ?: '../assets/images/default-course.png') ?>" alt="Course Image" class="card-img-top">
              <div class="card-body text-center">
                  <h3 class="card-title"><?= htmlspecialchars($course['Title']) ?></h3>
                  <p class="card-text"><?= htmlspecialchars($course['Description']) ?></p>
                  <p class="card-text"><strong>Price:</strong> $<?= htmlspecialchars($course['Price']) ?></p>
                  <a href="course.php?id=<?= urlencode($course['Id']) ?>" class="btn btn-primary">View Details</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No enrolled courses available.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Certificates Section -->
  <section id="certificates" class="section">
    <h2>Certificates</h2>
    <div class="container text-center">
      <div class="row">
        <!-- Implement certificate fetching logic here -->
        <div class="col-4 mb-5">
          <div class="card">
            <h3>Certificate 1</h3>
            <p>Completion of Web Development Bootcamp.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Available Courses Section -->
  <section id="available-courses" class="section">
    <h2>Available Courses</h2>
    <div class="container text-center">
      <div class="row">
        <!-- Implement available courses fetching logic here -->
        <div class="col-4 mb-5">
          <div class="card">
            <img src="../assets/images/default-course.jpg" alt="Course Image" class="card-img-top">
            <div class="card-body">
              <h3 class="card-title">Course name</h3>
              <p class="card-text">Course description</p>
              <a href="course.php" class="btn btn-primary">View Details</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
