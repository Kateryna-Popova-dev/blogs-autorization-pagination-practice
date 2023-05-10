<?php
session_start();
include __DIR__ . '/../functions/functions.php';
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
    <link rel="stylesheet" href="../style/style.css">
    <title>Document</title>
</head>
<body>
<div class="login-wrap">
    <div class="nav">
        <a class="nav__link" href="registration.php">Registration</a>
    </div>
    <div class="login">
        <?php
        if (hasErrors('method', 'httpRequest')) {
            echo "<p class='registration__error'>" . getMessages('method', 'httpRequest') . "</p>";
            removeMessage('method', 'httpRequest');
        }
        if (hasErrors('email', 'database')) {
            echo "<p class='login__error'>" . getMessages('email', 'database') . "</p>";
            removeMessage('email', 'database');
        }
        if (hasErrors('password', 'database')) {
            echo "<p class='login__error'>" . getMessages('password', 'database') . "</p>";
            removeMessage('password', 'database');
        }
        ?>
        <h5 class="login__title">Sign In</h5>
        <form action="../controllers/login.php" method="post" class="login__form">

            <input class="login__input email"
                   type="email"
                   name="email"
                   placeholder="Email"
                   value="<?php echo getInputValues('email');
                   removeMessage('email', 'values'); ?>"
            />
            <?php
            if (hasErrors('email')) {
                foreach (getMessages('email') as $message) {
                    echo "<p class='login__error'>" . $message . "</p>";
                }
                removeMessage('email');
            }
            ?>
            <div class="input-wrapper">
                <input id="pas1" class="login__input" type="password" name="password" placeholder="Password"
                />
                <i class="fas fa-eye fa-eye-slash icon-password"></i>
            </div>
            <div id="error"></div>
            <button type="submit" class="login__btn">Подтвердить</button>
        </form>
    </div>
</div>
<script src="../script.js"></script>
</body>
</html>
