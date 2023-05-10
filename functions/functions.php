<?php
include __DIR__ . '/../database.php';

function debug(...$args): void
{
    foreach ($args as $arg) {
        echo '<pre>';
        print_r($arg);
        echo '<pre>';
    }
    exit('debug stopped application');
}

function checkMethod(string $redirect = '', $page = 'pages')
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        setMessage('Method not allowed!', 'httpRequest', 'method');
        header("Location: " . LOCATION . $page . "/" . $redirect);
        exit;
    }
}

function setMessage(string|array $message, string $type = 'alerts', string $name = null): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        if ($name) {
            $_SESSION[$type][$name] = $message;
        } else {
            $_SESSION[$type] = $message;
        }

    }
}

function getMessages(string $name, string $type = 'alerts'): null|array|false|string
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return $_SESSION[$type][$name] ?? null;
    }
    return false;
}

function hasErrors(string $name, string $type = 'alerts'): bool
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return isset($_SESSION[$type][$name]);
    }
    return false;
}

function removeMessage(string $name, string $type = 'alerts'): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        unset($_SESSION[$type][$name]);
    }
}

/**
 * Save values of given fields to session for user to not enter them second time
 * @param array $post copy of $_POST
 * @param array $names list of fields to save
 * @return void
 */
function setInputValues(string $name, string $filterPost): void
{
    $_SESSION['values'][$name] = $filterPost;
}

/**
 * Function returns the saved fields
 * @param string $name
 * @param string $type
 * @return array|false|string|null
 */
function getInputValues(string $name, string $type = 'values'): null|array|false|string
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return $_SESSION[$type][$name] ?? null;
    }
    return false;
}

function generateToken($id): string
{
    $time = time();
    $randPart = rand(1000, 9999);
    return hash('md5', $id . $randPart . $time);
}

function getUserIp(): string
{
    return $_SERVER['REMOTE_ADDR'];
}

function getUserAgent(): string
{
    return $_SERVER['HTTP_USER_AGENT'];
}

/** Function filter post
 * @param string $name
 * @param string $type
 * @return string
 */
function filterPost(string $name, string $type = 'default'): string
{
    $value = filter_input(INPUT_POST, $name, FILTER_SANITIZE_ADD_SLASHES);
    $value = htmlspecialchars($value);
    switch ($type) {
        case 'email':
            $value = filter_var($value, FILTER_SANITIZE_EMAIL);
            break;
        case 'string':
            $value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            break;
        case 'int':
            $value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            break;
        case 'float':
            $value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
            break;
    }
    return $value;
}

function filterArrayPost(array $post): void
{
    foreach ($post as $key => $item) {
        filterPost($key);

        if ($key === 'name' || $key === 'password' || $key === 'password_confirm') {
            filterPost($key, 'string');
        }
        if ($key === 'email') {
            filterPost($key, 'email');
        }
    }
}

function reFilter($data)
{
    return htmlspecialchars_decode($data);
}


/**
 * @param array $file
 * @return false|mixed
 */
function saveFile(array $file): mixed
{
    $directory = BASE_PATH . '/storage/blogs/';

    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }

    if ($file['error']) {
        return false;
    }
    $filename = $file['name'];

    return move_uploaded_file($file['tmp_name'], "$directory/$filename") ? $filename : false;
}

function logger(string $message, string $fileName = 'log.txt', $user = true): void
{
    $directory = BASE_PATH . '/storage/logs/';

    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }
    $currentData = date('d.m.y / h.i.s');
    $newMessage = "[$currentData] ";
    if ($user) {
        $userId = checkAuth();
        $newMessage .= "[user #$userId] ";
    }
    $newMessage .= "[$message] " . PHP_EOL;
    $file = fopen($directory . $fileName, 'a');
    fwrite($file, $newMessage);
    fclose($file);
}
