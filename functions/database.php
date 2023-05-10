<?php

/** Function checks if the user is in the database.
 * @param string $email
 * @return bool
 */
function isEmailInDatabase(string $email): bool
{
    require_once "../database.php";
    $connect = connect();
    $query = "SELECT COUNT(*) as `counter` From Users WHERE email = :email";
    $statement = $connect->prepare($query);
    $statement->execute(['email' => $email]);
    $userEmail = $statement->fetch();
    return (bool)$userEmail['counter'];
}

function registrationUser(PDO $connect, array $data)
{
    try {
        $sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES(:name, :email, :password)";
        $statement = $connect->prepare($sql);
        $statement->execute($data);
        return $connect->lastInsertId();
    } catch (PDOException $e) {
        logger(serialize($e->getMessage()), 'error.txt', false);
        return false;
    }
}

function createSession(PDO $connect, array $data)
{
    try {
        $sql = "INSERT INTO `users_sessions` (`user_id`, `token`, `user_agent`, `ip`) VALUES(:user_id, :token, :user_agent, :ip)";
        $statement = $connect->prepare($sql);
        $statement->execute($data);
        return $connect->lastInsertId();
    } catch (PDOException) {
        logger(serialize($e->getMessage()), 'error.txt', false);
        return false;
    }
}

/**
 *  Function checks if the user is logged in
 * @return bool
 */
function checkAuth()
{
    $token = $_COOKIE['auth'] ?? false;
    if (!$token) {
        return false;
    }
    require_once __DIR__ . '/../database.php';
    $connect = connect();
    $session = getSession($connect, $token);

    if (!$session) {
        return false;
    }
    return $session['user_id'];
}

;
/** Get sessions info by auth token
 * @param PDO $connect
 * @param string $token
 * @return array|false
 */
function getSession(PDO $connect, string $token): array|bool
{
    try {
        $sql = "SELECT * FROM `users_sessions` WHERE `token` = ? LIMIT 1";
        $statement = $connect->prepare($sql);
        $statement->execute([$token]);
        return $statement->fetch();

    } catch (PDOException) {
        logger(serialize($e->getMessage()), 'error.txt', false);
        return false;
    }
}

function removeSession(PDO $connect, string $token)
{
    try {
        $sql = "DELETE  FROM `users_sessions` WHERE `token` = ? ";
        $statement = $connect->prepare($sql);
        $statement->execute([$token]);

    } catch (PDOException) {
        logger(serialize($e->getMessage()), 'error.txt', false);
        return false;
    }
}

function getUserData(PDO $connect, string $email): array
{
    $sql = "SELECT `password`, `id` FROM `users` WHERE  `email` = :email";
    $statement = $connect->prepare($sql);
    $statement->execute(['email' => $email]);
    return $userData = $statement->fetch();
}

function getUserNameByToken(PDO $connect, string $token): string
{
    $sql = "SELECT users.name
            FROM `users`
            INNER JOIN `users_sessions` ON users_sessions.user_id = users.id
            WHERE users_sessions.token = :token;";
    $statement = $connect->prepare($sql);
    $statement->execute(['token' => $token]);
    return $statement->fetch()['name'];
}

function getAllUsers(PDO $connect)
{
    try {
        $query = "SELECT `id`, `name` FROM `users`";
        $stmt = $connect->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logger(serialize($e->getMessage()), 'error.txt', false);
        return false;
    }
}
