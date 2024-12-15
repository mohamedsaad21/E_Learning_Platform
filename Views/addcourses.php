<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Courses</title>
    <link rel="stylesheet" href="../assets/css/addcourses.css">
</head>
<?php
include "../config/database.php";
// Fetch all categories from the database
$sql = "SELECT Id, Name FROM categories";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching categories: " . mysqli_error($conn));
}
?>
<body>
    <div class="container">
        <!-- Form Section -->
        <div class="form-container">
            <h2>Add Course</h2>
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                </div>
            <?php } ?>
            <form action="../Controllers/AddController.php" class="form" method="post" id="AddForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="Name">Name</label>
                    <input id="Name" name="Name" class="form-control" placeholder="Name" value="<?php 
                        if (isset($_SESSION['Name'])) echo htmlspecialchars($_SESSION['Name']);
                        unset($_SESSION['Name']);
                    ?>">
                    <span class="text-danger" data-validation-for="Name"></span>
                </div>
                <div class="form-group">
                    <label for="Price">Price</label>
                    <input id="Price" name="Price" class="form-control" placeholder="Price" value="<?php 
                        if (isset($_SESSION['Price'])) echo htmlspecialchars($_SESSION['Price']);
                        unset($_SESSION['Price']);
                    ?>">
                    <span class="text-danger" data-validation-for="Price"></span>
                </div>
                <div class="form-group">
                    <label for="Descriptions">Description</label>
                    <textarea id="Descriptions" name="Descriptions" class="form-control" placeholder="Description" value="<?php 
                        if (isset($_SESSION['Descriptions'])) echo htmlspecialchars($_SESSION['Descriptions']);
                        unset($_SESSION['Descriptions']);
                    ?>"></textarea>
                    <span class="text-danger" data-validation-for="Descriptions"></span>
                </div>
                <div class="form-group">
                    <label for="CategoryId">Category</label>
                    <select name="categoryId" id="category" required>
                        <option value="" disabled selected>Select a category</option>
                        <?php
                            // Generate the <option> elements for the dropdown
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['Id'] . "'>" . htmlspecialchars($row['Name']) . "</option>";
                            }
                        ?>
        </select>
                    <span class="text-danger" data-validation-for="CategoryId"></span>
                </div>
                <div class="form-group">
                    <label for="CreateDate">Create Date</label>
                    <input id="CreateDate" name="CreateDate" class="form-control" placeholder="Create Date" value="<?php 
                        if (isset($_SESSION['CreateDate'])) echo htmlspecialchars($_SESSION['CreateDate']);
                        unset($_SESSION['CreateDate']);
                    ?>">
                    <span class="text-danger" data-validation-for="CreateDate"></span>
                </div>
                <div class="form-group">
                    <label for="Thumbnail" class="custom-label">Thumbnail</label>
                    <img id="thumbnail" src="<?php echo isset($_SESSION['Thumbnail']) ? $_SESSION['Thumbnail'] : '../assets/imgs/Courses/default-course.png'; ?>" 
                         alt="Thumbnail" class="thumbnail-picture" style="max-width: 35%; margin-top: 10px;">
                    <input type="file" id="Thumbnail" name="Thumbnail" accept="image/*" class="custom-file-input"
                        onchange="document.getElementById('thumbnail').src = window.URL.createObjectURL(this.files[0])">
                    <label class="custom-file-label" for="Thumbnail">Choose picture...</label>
                    <span class="text-danger" data-validation-for="Thumbnail"></span>
                </div>
                <input class="btn" type="submit" value="Create" name="submit">
            </form>
        </div>
        <!-- Image Section -->
        <div class="image-container">
            <img src="../assets/imgs/login and regiser.png" alt="Illustration">
        </div>
    </div>
</body>
</html>