<?php
// Database connection
include "../config/database.php";

// Fetch data with JOIN to get course names and student names
$query = "
    SELECT 
        my_cart.CourseId,
        my_cart.StudentId,
        courses.Title AS CourseName,
        CONCAT(users.FirstName, ' ', users.LastName) AS StudentName
    FROM 
        my_cart
    JOIN 
        courses ON my_cart.CourseId = courses.Id
    JOIN 
        users ON my_cart.StudentId = users.Id
";
$result = mysqli_query($conn, $query);

// Initialize an empty array to store data
$cartItems = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cartItems[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart View</title>
    <link rel="stylesheet" href="../assets/css/CartStyle.css">
</head>
<body>
<div class="container">
    <h3>Cart Items</h3>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Student Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($cartItems)): ?>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['CourseName']) ?></td>
                        <td><?= htmlspecialchars($item['StudentName']) ?></td>
                        <td>
                            <!-- Form to delete course using POST -->
                            <form action="../Controllers/delete_cart.php" method="POST" onsubmit="return confirm('Are you sure you want to remove this course from the cart?')">
                                <input type="hidden" name="courseId" value="<?= $item['CourseId'] ?>">
                                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No items in the cart.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>