<?php
session_start();
include __DIR__ . '/functions/functions.php';
include __DIR__ . '/functions/database.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link
        rel="stylesheet"
        href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
        crossorigin="anonymous"
    />
    <link rel="stylesheet" href="style/style.css">
    <title>Document</title>
</head>
<body>
<div class="main">
    <?php
    if (!checkAuth()) {
        echo "
<h3 class='main__title'>Please authorization for watching closed content!</h3>
<div class='nav'>
    <a class='nav__link' href='pages/registration.php'>Registration</a>
    <a class='nav__link'' href='pages/login.php'>Login</a>
</div>
";
    } else {
        echo "
<div class='nav'>
    <a class='nav__link' href='pages/blog.php'>BLOG</a>
    <a class='nav__link' href='pages/blog_add.php'>Add blog</a>
    <a class='nav__link' href='controllers/logout.php'>Logout</a>
</div>
";
    }
    ?>
</div>
</body>
</html>
