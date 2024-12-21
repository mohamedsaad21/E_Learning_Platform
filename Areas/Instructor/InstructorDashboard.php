<?php
session_start();
if($_SESSION['role'] != "Instructor"){
    header("Location: ../../AccessDenied.php");
}
$CourseId = $_GET['id'];
include "../../config/database.php";
 $query = "SELECT * FROM students_courses INNER JOIN users ON students_courses.StudentId = users.Id WHERE CourseId = $CourseId";
 $result = mysqli_query($conn, $query);  
 $_SESSION['CourseId'] = $CourseId;
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Course Dashboard</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" /> 
           <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
           <link rel="stylesheet" href="../../assets/css/AdminCourses.css">

      </head>  
      <body>  
      <div class="navbar">
               <h2>E-Learners</h2>
               <a href="../../index.php">Home</a>
               <a href="../../Views/AllCourses.php">All Courses</a>
               <a href="#">Enrolled Courses</a>
               <a href="">Certificates</a>
               <a href="../../Views/Contact.php">Contact Us</a>
               <a href="../../Controllers/Logout.php" class="btn btn-danger">Logout</a>
          </div>
           <br /><br />  
           <div class="container">  
           <div class="admin-dashboard-header">
                    <h1>Students Dashboard</h1>
               </div>  
                <div class="row mb-5">                
        </div>
                <div class="table-responsive">  
                     <table id="course_data" class="table table-striped table-bordered">  
                          <thead>  
                               <tr>  
                                    <td>First Name</td>  
                                    <td>Last Name</td>  
                                    <td>Username</td> 
                                    <td>Email</td> 
                                    <td></td> 
                               </tr>  
                          </thead>  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                               echo '  
                               <tbody>
                               <tr>  
                                    <td>'.$row["FirstName"].'</td>  
                                    <td>'.$row["LastName"].'</td>  
                                    <td>'.$row["Username"].'</td>                                      
                                    <td>'.$row["Email"].'</td>                                      
                                    <td>                                                 
                                         <a href="DeleteUserFromCourse.php?id=' .$row['StudentId'] . '" class="btn btn-danger">
                                         <i class="bi bi-trash-fill"></i> Delete
                                         </a>
                                    </td>                                      
                               </tr>  
                               </tbody>
                               ';  
                          }  
                          ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      $('#course_data').DataTable();  
 });  
 </script>  