<?php
session_start();
if($_SESSION['role'] != "Admin"){
    header("Location: ../../AccessDenied.php");
}
include "../../config/database.php";
 $query ="SELECT users.*, roles.role_name FROM users INNER JOIN roles ON users.role_Id = roles.role_id";  
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
      </head>  
      <body>  
           <br /><br />  
           <div class="container">  
                <h3 align="center">Users List</h3>  
                <br />  
                <div class="row mb-5">
                <?php 
                if($_SESSION['role'] === "Admin"):?>
                    <a class="text-decoration-none" href="../Controllers/AddController.php">
                        <i class="bi bi-plus-circle"></i> Add New Course
                    </a>
                <?php endif?>
        </div>
                <div class="table-responsive">  
                     <table id="course_data" class="table table-striped table-bordered">  
                          <thead>  
                               <tr>  
                                    <td>First Name</td>  
                                    <td>Last Name</td>  
                                    <td>Username</td> 
                                    <td>Email</td> 
                                    <td>Role</td> 
                                    <td></td> 
                               </tr>  
                          </thead>  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {  
                               echo '  
                               <tr>  
                                    <td>'.$row["FirstName"].'</td>  
                                    <td>'.$row["LastName"].'</td>  
                                    <td>'.$row["Username"].'</td>                                      
                                    <td>'.$row["Email"].'</td>                                      
                                    <td>'.$row["role_name"].'</td>                                      
                                    <td>
                                        <a href="UpdateController.php" class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>  Edit
                                        </a>                                      
                                        <a href="DeleteCourseController.php" class="btn btn-danger">
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
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      $('#course_data').DataTable();  
 });  
 </script>  