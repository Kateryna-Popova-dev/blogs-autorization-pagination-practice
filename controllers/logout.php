<?php
include __DIR__ . "/../database.php";
include __DIR__ . "/../functions/database.php";
if (!checkAuth()) {
    header("Location: " . LOCATION);
}
$token = $_COOKIE['auth'];
$connect = connect();
removeSession($connect, $token);

if (isset($_COOKIE['auth'])) {
    setcookie('auth', "", 1, '/');
};

header("Location: " . LOCATION);


