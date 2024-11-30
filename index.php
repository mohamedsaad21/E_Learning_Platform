<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="Views/register.php">Register</a>
    <a href="Views/login.php">Login</a>
    <a href="Views/logout.php">Logout</a>
    <?php  
        echo $_SESSION['Email'];
    ?>
</body>
</html>