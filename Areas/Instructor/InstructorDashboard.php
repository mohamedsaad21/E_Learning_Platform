 <?php
session_start();
if ($_SESSION['role'] != "Instructor") {
    header("Location: ../../AccessDenied.php");
    exit();
}

include "../../config/database.php";

// Sanitize and validate CourseId
$CourseId = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;
if (!$CourseId) {
    die("Invalid Course ID.");
}

$query = "SELECT * FROM students_courses 
          INNER JOIN users ON students_courses.StudentId = users.Id 
          WHERE CourseId = $CourseId";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$_SESSION['CourseId'] = $CourseId;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" /> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    <link rel="stylesheet" href="../../assets/css/AdminUsers.css">
</head>
<body>
<div class="navbar">
    <h2>E-Learners</h2>
    <a href="../../index.php">Home</a>
    <a href="../../Views/InstructorCourses.php">Your Courses</a>
    <a href="../../Views/CourseSections.php?id=<?= urlencode($CourseId) ?>">Watch Course</a>
    <a href="../../Views/Contact.php">Contact Us</a>
    <a href="../../Controllers/Logout.php" class="btn btn-danger">Logout</a>
</div>
<br /><br />
<div class="container">
    <div class="admin-dashboard-header">
        <h1>Instructor Dashboard</h1>
    </div>
    <div class="row mb-5">
        <?php if ($_SESSION['role'] === "Admin"): ?>
            <a class="text-decoration-none" href="../../Views/addcourses.php">
                <i class="bi bi-plus-circle"></i> Add New Course
            </a>
        <?php endif ?>
    </div>
    <div class="table-responsive">
        <table id="course_data" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["FirstName"]) ?></td>
                        <td><?= htmlspecialchars($row["LastName"]) ?></td>
                        <td><?= htmlspecialchars($row["Username"]) ?></td>
                        <td><?= htmlspecialchars($row["Email"]) ?></td>
                        <td>                                                 
                        <a href="DeleteUserFromCourse.php?id=<?= $row['StudentId'] ?>" class="btn btn-danger">
                            <i class="bi bi-trash-fill"></i> Delete
                        </a>
                         </td>    
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
<script>
$(document).ready(function() {
    $('#course_data').DataTable();
});
</script>