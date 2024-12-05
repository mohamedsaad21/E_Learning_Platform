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
      <h1>Welcome <span class="studentName"> Student Name</span></h1>
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
        <!-- loop here on the div , and bind the data from data base  , only enrolled courses in the student table-->
        <div class="col-4 mb-5">
          <div class="card">
            <img src="" alt="">
            <h3>Course name</h3>
            <p>course description</p>
            <a href="course.php" class="details-btn">link to course details page </a>
            <!-- SEND course id with it , from the database , so it goes to details page , with the content of the course from the database -->
          </div>
        </div>
      </div>
    </div>

  </section>

  <!-- Certificates Section -->
  <section id="certificates" class="section">
    <h2>Certificates</h2>
    <div class="container text-center">
      <div class="row">
        <!-- loop here on the div , and bind the data from data base , only display certificates of finished courses   -->
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
        <!-- loop here on the div , and bind the data from data base , all the other courses that the user is not enrolled in   -->
        <div class="col-4 mb-5">
          <div class="card">
            <img src="" alt="">
            <h3>Course name</h3>
            <p>course description</p>
            <a href="course.php" class="details-btn">link to course details page </a>
            <!-- SEND course id with it , from the database , so it goes to details page , with the content of the course from the database -->
          </div>
        </div>
      </div>
    </div>

  </section>
</body>

</html>