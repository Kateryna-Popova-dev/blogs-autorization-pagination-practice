<?php
session_start();
include __DIR__ . '/../functions/database.php';
include __DIR__ . '/../functions/functions.php';
include __DIR__ . '/../functions/blog.php';
include_once __DIR__ . '/../database.php';
$connect = connect();

if (!checkAuth()) {
    header("Location: " . LOCATION);
}
$userName = getUserNameByToken($connect, $_COOKIE['auth']);
$page = $_GET['page'] ?? 1;
$productPerPage = 3;
$productCount = countBlogs($connect);
$offset = ($page - 1) * $productPerPage;
$blogs = getAllBlogs($connect, $productPerPage, $offset);
$maxPage = ceil($productCount / $productPerPage)
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style/style.css">
    <title>Document</title>
</head>
<body>

<div class="blog-wrap">
    <div class="nav">
        <a class='nav__link' href='blog_add.php'>Add blog</a>
        <a class='nav__link' href='../controllers/logout.php'>Logout</a>
    </div>
    <p class="blog-wrap__title">Hello <?= reFilter($userName) ?></p>
    <h2 class="blog-wrap__title">Closed content</h2>

    <div class="blogs">
        <?php if ($blogs) { ?>
            <?php
            foreach ($blogs as $blog) {
                include "../templates/_blog_card.php";
            }
            ?>
        <?php } ?>
    </div>
    <nav class="pagination">
        <?php for ($i = 1; $i < $maxPage + 1; $i++) { ?>
            <a href="?page=<?= $i ?>" class="pagination__item"><?= $i ?></a>
        <?php } ?>
    </nav>
</div>
</body>
</html>

