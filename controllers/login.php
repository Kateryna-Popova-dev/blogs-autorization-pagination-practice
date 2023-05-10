<?php
session_start();

include __DIR__ . '/../functions/validator.php';
include __DIR__ . '/../functions/functions.php';
include __DIR__ . '/../functions/database.php';

checkMethod("/login.php");

if (isset($_COOKIE['auth'])) {
    setcookie('auth', "", 1, '/');
};

$errors = validate($_POST, [
    'email' => 'required|min_length[3]|email',
]);
if ($errors) {
    setMessage($errors);
    header("Location: " . LOCATION . "/pages/login.php");
    exit;
}

if (isEmailInDatabase($_POST['email'])) {
    $connect = connect();
    $userData = getUserData($connect, $_POST['email']);

    if (password_verify($_POST['password'], $userData['password'])) {
        $token = generateToken($userData['id']);

        $sessionId = createSession($connect, [
            'user_id' => $userData['id'],
            'token' => $token,
            'user_agent' => getUserAgent(),
            'ip' => getUserIp(),
        ]);

        setcookie('auth', $token, time() + (3600 * 24 * 7), '/');
    } else {
        setMessage('Incorrect password or login', 'database', 'password');
        header("Location: " . LOCATION . "/pages/login.php");
        exit();
    }
} else {
    setMessage('user does not exist', 'database', 'email');
    header("Location: " . LOCATION . "/pages/login.php");
    exit();
}

header("Location: " . LOCATION . "/pages/blog.php");

