<?php
session_start();
if($_SESSION['role'] != "Admin"){
    header("Location: ../../AccessDenied.php");
}
include "../../config/database.php";
 $query ="SELECT courses.*, Username, categories.Name FROM courses INNER JOIN users ON users.Id = courses.InstructorId INNER JOIN categories ON courses.categoryId = categories.Id";  
 $result = mysqli_query($conn, $query);  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Course List</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" /> 
           <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
           <link rel="stylesheet" href="assets/css/all.min.css">
           <link rel="stylesheet" href="assets/css/bootstrap.min.css">
           <link rel="stylesheet" href="../../assets/css/AdminCourses.css">

      </head>  
      <body>  
      <div class="navbar">
               <h2>E-Learners</h2>
               <a href="../../index.php">Home</a>
               <a href="../../Controllers/Logout.php" class="btn btn-danger">Logout</a>
          </div>
           <br /><br />  
           <div class="container">  
           <div class="admin-dashboard-header">
                    <h1>Admin Dashboard</h1>
               </div>  
                <div class="row mb-5">
                <?php 
                if($_SESSION['role'] === "Admin"):?>
                    <a class="text-decoration-none" href="../../Views/addcourses.php">
                        <i class="bi bi-plus-circle"></i> Add New Course
                    </a>
                <?php endif?>
        </div>
                <div class="table-responsive">  
                     <table id="course_data" class="table table-striped table-bordered">  
                          <thead>  
                               <tr>  
                                    <td>Title</td>  
                                    <td>Instructor</td> 
                                    <td>Category</td> 
                                    <td></td> 
                               </tr>  
                          </thead>  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                               echo '  
                               <tr>  
                                    <td>'.$row["Title"].'</td>  
                                    <td>'.$row["Username"].'</td>                                      
                                    <td>'.$row["Name"].'</td>                                      
                                    <td>
                                        <a href="../../Views/updatecourse.php?id=' .$row['Id'] . '" class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>  Edit
                                        </a>                                      
                                        <a href="../../Views/deletecourse.php?id=' .$row['Id'] . '"class="btn btn-danger">
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
           <script src="assets/js/bootstrap.bundle.min.js"></script>
           <script src="assets/js/all.min.js"></script>
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      $('#course_data').DataTable();  
 });  
 </script>  