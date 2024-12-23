<?php
session_start();
if ($_SESSION['role'] != "Admin") {
    header("Location: ../../AccessDenied.php");
    exit();
}

include "../../config/database.php";

$query = "SELECT users.*, roles.role_name FROM users INNER JOIN roles ON users.role_Id = roles.role_id";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
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
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/AdminUsers.css">
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
    <div class="table-responsive">
        <table id="course_data" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Role</td>
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
                        <td><?= htmlspecialchars($row["role_name"]) ?></td>
                        <td>
                            <a href="DeleteUser.php?id=<?= $row['Id'] ?>" class="btn btn-danger">
                            <i class="bi bi-trash-fill"></i> Delete
                        </a>
                        </td>   
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</div>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/all.min.js"></script>
</body>
</html>

<script>
$(document).ready(function() {
    $('#course_data').DataTable();
});
</script>
