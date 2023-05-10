<?php
session_start();

include __DIR__ . '/../functions/validator.php';
include __DIR__ . '/../functions/functions.php';
include __DIR__ . '/../functions/database.php';
include __DIR__ . '/../functions/blog.php';
$connect = connect();

checkMethod("/login.php");
setInputValues('title', filterPost('title', 'string'));
setInputValues('content', filterPost('content', 'string'));

$errors = validate($_POST, [
    'title' => 'required|min_length[5]|max_length[255]',
    'content' => 'required|min_length[5]|max_length[20000]',
    'author_id' => 'required',
]);
$errorsFiles = validate($_FILES, [
    'image' => 'image',
]);
if ($errorsFiles) {
    $errors['image'] = $errorsFiles['image'];
}

if ($errors) {
    setMessage($errors);
    header("Location: " . LOCATION . "/pages/blog_add.php");
    exit();
}

if ($fileName = saveFile($_FILES['image'])) {

    $data = [
        'author_id' => filterPost('author_id'),
        'title' => filterPost('title'),
        'content' => filterPost('content'),
        'image' => 'storage/blogs/' . $fileName,
    ];
    if ($blogId = blogAdd($connect, $data)) {
        logger("blog #$blogId added");
        header("Location: " . LOCATION . "/pages/blog.php");
    }
}




