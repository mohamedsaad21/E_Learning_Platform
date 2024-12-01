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
      <h1>Welcome, Student Name</h1>
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
    <div class="card-container">
      <div class="card">
        <h3>Course 1</h3>
        <p>Learn the basics of web development.</p>
        <button class="details-btn" >View Details</button>
      </div>
      <div class="card">
        <h3>Course 2</h3>
        <p>Advanced JavaScript programming.</p>
        <button class="details-btn" >View Details</button>
      </div>
      <div class="card">
        <h3>Course 3</h3>
        <p>Introduction to database management.</p>
        <button class="details-btn" >View Details</button>
      </div>
    </div>
  </section>

  <!-- Certificates Section -->
  <section id="certificates" class="section">
    <h2>Certificates</h2>
    <div class="card-container">
      <div class="card">
        <h3>Certificate 1</h3>
        <p>Completion of Web Development Bootcamp.</p>
      </div>
      <div class="card">
        <h3>Certificate 2</h3>
        <p>Advanced JavaScript Certification.</p>
      </div>
    </div>
  </section>

  <!-- Available Courses Section -->
  <section id="available-courses" class="section">
    <h2>Available Courses</h2>
    <div class="card-container">
      <div class="card">
        <h3>Course 4</h3>
        <p>Data Structures and Algorithms.</p>
        <button class="details-btn" >View Details</button>
      </div>
      <div class="card">
        <h3>Course 5</h3>
        <p>Machine Learning for Beginners.</p>
        <button class="details-btn" >View Details</button>
      </div>
      <div class="card">
        <h3>Course 6</h3>
        <p>UI/UX Design Principles.</p>
        <button class="details-btn" >View Details</button>
      </div>
    </div>
  </section>
</body>
</html>
