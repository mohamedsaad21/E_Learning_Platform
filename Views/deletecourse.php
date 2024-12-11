<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <link rel="stylesheet" href="../assets/css/addcourses.css">
</head>
<body>
<?php
session_start();
include "../config/database.php";

// Check if the 'id' is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Course ID not specified.");
}

$courseId = intval($_GET['id']); // Sanitize input

// Fetch course details
$courseSql = "SELECT * FROM `Courses` WHERE `id` = ?";
$courseStmt = mysqli_prepare($conn, $courseSql);
if (!$courseStmt) {
    die("Database query failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($courseStmt, "i", $courseId);
mysqli_stmt_execute($courseStmt);
$courseResult = mysqli_stmt_get_result($courseStmt);
if ($courseResult && mysqli_num_rows($courseResult) > 0) {
    $course = mysqli_fetch_assoc($courseResult);
} else {
    die("Course not found.");
}
mysqli_stmt_close($courseStmt);

// Fetch all categories
$categoriesSql = "SELECT Id, Name FROM categories";
$categoriesResult = mysqli_query($conn, $categoriesSql);
if (!$categoriesResult) {
    die("Error fetching categories: " . mysqli_error($conn));
}
?>
<div class="container">
    <div class="form-container">
        <h2>Edit Course</h2>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <p><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            </div>
        <?php } ?>
        <form action="../Controllers/DeleteCourseController.php" method="post">
            <!-- ERROR -->
            <input type="hidden" name="courseId" value="<?php echo htmlspecialchars($course['id']); ?>">
            <div class="form-group">
                <label for="Name">Name</label>
                <input disabled id="Name" name="Name" class="form-control" placeholder="Name" value="<?php echo htmlspecialchars($course['Title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="Price">Price</label>
                <input disabled id="Price" name="Price" class="form-control" placeholder="Price" value="<?php echo htmlspecialchars($course['Price']); ?>" required>
            </div>
            <div class="form-group">
                <label for="Descriptions">Description</label>
                <textarea disabled id="Descriptions" name="Descriptions" class="form-control" placeholder="Description" required><?php echo htmlspecialchars($course['Description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="CategoryId">Category</label>
                <select disabled name="categoryId" id="CategoryId" required>
                    <option value="" disabled>Select a category</option>
                    <?php while ($category = mysqli_fetch_assoc($categoriesResult)) { ?>
                        <option value="<?php echo $category['Id']; ?>" <?php echo ($course['CategoryId'] == $category['Id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['Name']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Thumbnail">Thumbnail</label>
                <img id="thumbnail" src="<?php echo htmlspecialchars($course['ImageUrl']); ?>" alt="Thumbnail" style="max-width: 35%; margin-top: 10px;">
            </div>
            <button class="btn" type="submit" name="delete">Delete Course</button>
        </form>
    </div>
</div>
</body>
</html>
