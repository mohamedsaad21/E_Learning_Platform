<?php
session_start();
if ($_SESSION['role'] != "Admin") {
     header("Location: ../../AccessDenied.php");
}
include "../../config/database.php";
$query = "SELECT courses.*, Username, categories.Name FROM courses INNER JOIN users ON users.Id = courses.InstructorId INNER JOIN categories ON courses.categoryId = categories.Id";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>

<head>
     <title>Course List</title>

     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">


     <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
          <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" /> 
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">  -->
     <link rel="stylesheet" href="../../assets/css/all.min.css">
     <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="../../assets/css/Admin.css">

</head>

<body>


     <header>
          <nav class="navbar navbar-expand-lg">
               <div class="container-fluid">
                    <!-- Logo -->
                    <a href="../../index.php" class="logo navbar-brand">E-Learners</a>

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
                                   <li class="nav-item"><a class="nav-link" href="cart_view.php">Go to Cart</a></li>

                              <?php endif; ?>
                              <li class="nav-item"><a class="nav-link" href="Views/contact.php">Contact Us</a></li>
                              <?php if (isset($_SESSION['role']) && $_SESSION['role'] === "Admin"): ?>
                                   <li class="nav-item dropdown">
                                        <a class="dropdown-toggle nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                             Content Management
                                        </a>
                                        <ul class="dropdown-menu">
                                             <li><a class="dropdown-item" href="Courses.php">Courses</a></li>
                                             <li><a class="dropdown-item" href="Users.php">Users</a></li>
                                        </ul>
                                   </li>
                              <?php endif ?>
                         </ul>

                         <!-- Auth Buttons -->
                         <div class="auth-buttons d-flex">
                              <?php if (isset($_SESSION['user_id'])): ?>
                                   <a href="#" class="login-btn me-2"><?php echo $_SESSION['username']; ?></a>
                                   <a href="../../Controllers/Logout.php" class="register-btn">Log Out</a>
                              <?php else: ?>
                                   <a href="../../Views/login.php" class="login-btn me-2">Login</a>
                                   <a href="../../Views/register.php" class="register-btn">Register</a>
                              <?php endif; ?>
                         </div>
                    </div>
               </div>
          </nav>
     </header>


     <div class="container">
          <div class="admin-dashboard-header">
               <h1>Admin Dashboard</h1>
          </div>
          <div class="row mb-5">

          </div>
          <div class="table-responsive">
               <table id="course_data" class="responsiveTableWidth table table-striped table-bordered">
                    <thead>
                         <tr>
                              <td>Title</td>
                              <td>Instructor</td>
                              <td>Category</td>
                              <td></td>
                         </tr>
                    </thead>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                         echo '  
                               <tr>  
                               <td>' . $row["Title"] . '</td>  
                               <td>' . $row["Username"] . '</td>                                      
                               <td>' . $row["Name"] . '</td>                                      
                               <td>
                               <a href="../../Views/updatecourse.php?id=' . $row['Id'] . '" class="btn btn-warning">
                               <i class="bi bi-pencil-square"></i>  Edit
                               </a>                                      
                               <a href="../../Views/deletecourse.php?id=' . $row['Id'] . '"class="btn btn-danger">
                               <i class="bi bi-trash-fill"></i> Delete
                               </a>
                               </td>                                      
                               </tr>
                               ';
                    }
                    ?>
               </table>
          </div>
     </div>
     <script src="../../assets/js/bootstrap.bundle.min.js"></script>
     <script src="../../assets/js/all.min.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
</body>

</html>
<script>
     $(document).ready(function() {
          $('#course_data').DataTable();
     });
</script>