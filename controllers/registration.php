<?php
session_start();
include __DIR__ . '/../functions/functions.php';
include __DIR__ . '/../functions/validator.php';
include __DIR__ . '/../functions/database.php';
include __DIR__ . '/../config.php';
include_once __DIR__ . '/../database.php';

checkMethod('/registration.php');
filterArrayPost($_POST);
setInputValues('name', filterPost('name', 'string'));
setInputValues('email', filterPost('email', 'email'));

$errors = validate($_POST, [
    'name' => 'required|min_length[3]|max_length[50]',
    'email' => 'required|min_length[3]|email',
    'password' => 'required|min_length[2]',
    'password_confirm' => 'required|password_confirm',
]);
$userData = [
    'name' => filterPost('name'),
    'email' => filterPost('email'),
    'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
];

if ($errors) {
    setMessage($errors);
    header("Location: " . LOCATION . "/pages/registration.php");
} else if (isEmailInDatabase($_POST['email'])) {
    setMessage('user already exist', 'database', 'email');
    header("Location: " . LOCATION . "/pages/registration.php");
} else {
    $connect = connect();
    $userId = registrationUser($connect, $userData);
    if (!$userId) {
        setMessage('Data Base Error', 'database', 'error');
        header("Location: " . LOCATION . "/pages/registration.php");
    };
    $token = generateToken($userId);

    $sessionData = [
        'user_id' => $userId,
        'token' => $token,
        'user_agent' => getUserAgent(),
        'ip' => getUserIp(),
    ];
    $sessionId = createSession($connect, $sessionData);

    if (!$sessionId) {
        header("Location: " . LOCATION . '/pages/registration.php');
    };
    setcookie('auth', $token, time() + (3600 * 24 * 7), '/');
    header("Location: " . LOCATION . "/pages/blog.php");
}





