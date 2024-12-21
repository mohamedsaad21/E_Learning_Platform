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
                    <input type="number" id="Price" name="Price" class="form-control" placeholder="Price" value="<?php 
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
                    <input type="date" id="CreateDate" name="CreateDate" class="form-control" placeholder="Create Date" value="<?php 
                        if (isset($_SESSION['CreateDate'])) echo htmlspecialchars($_SESSION['CreateDate']);
                        unset($_SESSION['CreateDate']);
                    ?>">
                    <span class="text-danger" data-validation-for="CreateDate"></span>
                </div>
                <div class="form-group">
                    <label for="Thumbnail" class="custom-label">Thumbnail</label>

                    <input type="file" id="Thumbnail" name="Thumbnail" accept="image/*" class="custom-file-input"
                        onchange="document.getElementById('thumbnail').src = window.URL.createObjectURL(this.files[0])">
                    <label class="custom-file-label" for="Thumbnail">Choose picture...</label>
                    <span class="text-danger" data-validation-for="Thumbnail"></span>
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
                <input class="btn" type="submit" value="Create" name="submit">
            </form>
        </div>

        <!-- Image Section -->
        <div class="image-container">
                <img id="thumbnail" src="<?php echo isset($_SESSION['Thumbnail']) ? $_SESSION['Thumbnail'] : '../assets/imgs/Courses/default-course.png'; ?>" 
                    alt="Thumbnail" class="thumbnail-picture" >
        </div>
    </div>

    <script src="https://cdn.tiny.cloud/1/onwc6tv37kcq7dykoko9t9rkug20er3cy9ohpz2thhx161aw/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
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

//######################################

    tinymce.init({
    selector: 'textarea',
    plugins: [
      // Core editing features
        'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until Dec 30, 2024:
        'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    });


</script>
</body>
</html>