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
                    <p><?php echo $_SESSION['error'];
                        unset($_SESSION['error']); ?></p>
                </div>
            <?php } ?>
            <form action="../Controllers/UpdateController.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="courseId" value="<?php echo $courseId ?>">
                <div class="form-group">
                    <label for="Name">Name</label>
                    <input id="Name" name="Name" class="form-control" placeholder="Name" value="<?php echo htmlspecialchars($course['Title']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="Price">Price</label>
                    <input id="Price" name="Price" class="form-control" placeholder="Price" value="<?php echo htmlspecialchars($course['Price']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="Descriptions">Description</label>
                    <textarea id="Descriptions" name="Descriptions" class="form-control" placeholder="Description" required><?php echo htmlspecialchars($course['Description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="CategoryId">Category</label>
                    <select name="categoryId" id="CategoryId" required>
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
                    <img id="thumbnail" src="../<?php echo htmlspecialchars(str_replace('../', '', $course['ImageUrl'])); ?>" alt="Thumbnail" style="max-width: 35%; margin-top: 10px;">
                    <input type="file" id="Thumbnail" name="Thumbnail" accept="image/*" onchange="document.getElementById('thumbnail').src = window.URL.createObjectURL(this.files[0])">
                </div>
                <div class="form-group">
                    <!-- Input for number of sections -->
                    <label>Number of Sections:</label>
                    <input type="number" id="num_sections" min="1" max="10" required>
                    <button type="button" onclick="generateSections()">Add Sections</button>

                    <hr>
                    <!-- Sections Container -->
                    <div id="sections_container"></div>
                    <span class="text-danger" data-validation-for="Thumbnail"></span>
                </div>

                <button class="btn" type="submit" name="submit">Update Course</button>
            </form>
        </div>
    </div>


    <script>
        // Function to generate dynamic sections
        function generateSections() {
            const numSections = document.getElementById('num_sections').value;
            const container = document.getElementById('sections_container');

            // Clear previous content
            container.innerHTML = '';

            // Generate sections and video inputs dynamically
            for (let i = 0; i < numSections; i++) {
                const sectionDiv = document.createElement('div');
                sectionDiv.className = 'section';
                sectionDiv.innerHTML = `
                    <h6>Section ${i + 1}</h6>
                    <label>Section Title:</label>
                    <input type="text" name="sections[${i}][section_title]" required><br>

                    <label>Section Description:</label>
                        <textarea id="Descriptions" name="Descriptions" class="form-control" placeholder="Description" value="<?php
                                                                                                                                if (isset($_SESSION['Descriptions'])) echo htmlspecialchars($_SESSION['Descriptions']);
                                                                                                                                unset($_SESSION['Descriptions']);
                                                                                                                                ?>"></textarea><br>

                    <label>Videos:</label>
                    <input type="file" name="sections[${i}][videos][]" id="videos_${i}" min="1" max="10" accept="video/*" multiple required>

                `;
                container.appendChild(sectionDiv);
            }
        }
    </script>
</body>

</html>