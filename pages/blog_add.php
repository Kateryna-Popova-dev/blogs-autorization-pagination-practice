<?php
session_start();
include __DIR__ . '/../functions/functions.php';
include __DIR__ . '/../functions/database.php';
include_once __DIR__ . '/../database.php';
$connect = connect();
$users = getAllUsers($connect);
?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
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
    <link rel="stylesheet" href="../style/style.css">
    <title>Document</title>
</head>
<body>
<div class="addBlog-wrap">
    <div class="nav">
        <a class='nav__link' href='blog.php'>BLOG</a>
        <a class='nav__link' href='../controllers/logout.php'>Logout</a>
    </div>
    <div class="addBlog">
        <?php
        if (hasErrors('method', 'httpRequest')) {
            echo "<p class='registration__error'>" . getMessages('method', 'httpRequest') . "</p>";
            removeMessage('method', 'httpRequest');
        }
        ?>
        <h5 class="addBlog__title">Add blog</h5>
        <form action="../controllers/blog_add.php" method="post" enctype="multipart/form-data" class="addBlog__form">

            <input class="addBlog__input-title "
                   type="text"
                   name="title"
                   placeholder="Title"
                   value="<?php echo getInputValues('title');
                   removeMessage('title', 'values'); ?>"
            />
            <?php
            if (hasErrors('title')) {
                foreach (getMessages('title') as $message) {
                    echo "<p class='login__error'>" . $message . "</p>";
                }
                removeMessage('title');
            }
            ?>
            <div class="addBlog__addFile">
                <p class="addBlog__text">Select image:</p>
                <input class="addBlog__file"
                       type="file"
                       name="image"
                >
            </div>
            <?php
            if (hasErrors('image')) {
                foreach (getMessages('image') as $message) {
                    echo "<p class='addBlog__error'>" . $message . "</p>";
                }
                removeMessage('image');
            }
            ?>
            <p class="addBlog__text">Add content:</p>
            <textarea class="addBlog__input-content "
                      type="text"
                      name="content"
                      placeholder="Content"
            ><?php echo getInputValues('content');
                removeMessage('content', 'values'); ?></textarea>
            <?php
            if (hasErrors('content')) {
                foreach (getMessages('content') as $message) {
                    echo "<p class='addBlog__error'>" . $message . "</p>";
                }
                removeMessage('content');
            }
            ?>
            <select name="author_id" class="addBlog__select">
                <option value="" selected>Select author</option>
                <?php foreach ($users as $user) { ?>
                    <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                <?php } ?>
            </select>
            <?php
            if (hasErrors('author_id')) {
                foreach (getMessages('author_id') as $message) {
                    echo "<p class='addBlog__error'>" . $message . "</p>";
                }
                removeMessage('author_id');
            }
            ?>
            <button type="submit" class="login__btn addBlog__submit">Подтвердить</button>
        </form>
    </div>
    <script src="../script.js"></script>
</body>
</html>
