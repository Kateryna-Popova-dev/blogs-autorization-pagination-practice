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
<div class="registration-wrap">
    <div class="nav">
        <a class="nav__link" href="login.php">Login</a>
    </div>
    <div class="registration">
        <?php
        if (hasErrors('method', 'httpRequest')) {
            echo "<p class='registration__error'>" . getMessages('method', 'httpRequest') . "</p>";
            removeMessage('method', 'httpRequest');
        }

        if (hasErrors('email', 'database')) {
            echo "<p class='login__error'>" . getMessages('email', 'database') . "</p>";
            removeMessage('email', 'database');
        }
        ?>
        <h5 class="registration__title">Create account</h5>
        <span class="registration__text-info">Register to use convenient features and checkout within a moment.</span>
        <form action="../controllers/registration.php" method="post" class="registration__form">
            <input class="registration__input name"
                   name="name"
                   placeholder="Name"
                   value="<?php echo getInputValues('name');
                   removeMessage('name', 'values'); ?>"
            />
            <?php
            if (hasErrors('name')) {
                foreach (getMessages('name') as $message) {
                    echo "<p class='registration__error'>" . $message . "</p>";
                }
                removeMessage('name');
            }
            ?>
            <input class="registration__input email"
                   type="email"
                   name="email"
                   placeholder="Email"
                   value="<?php echo getInputValues('email');
                   removeMessage('email', 'values'); ?>"
            />
            <?php
            if (hasErrors('email')) {
                foreach (getMessages('email') as $message) {
                    echo "<p class='registration__error'>" . $message . "</p>";
                }
                removeMessage('email');
            }
            ?>
            <div class="input-wrapper">
                <input id="pas1" class="registration__input" type="password" name="password" placeholder="Password"
                />
                <i class="fas fa-eye fa-eye-slash icon-password"></i>
                <?php
                if (hasErrors('password')) {
                    foreach (getMessages('password') as $message) {
                        echo "<p class='registration__error'>" . $message . "</p>";
                    }
                    removeMessage('password');
                }
                ?>
            </div>
            <div class="input-wrapper">
                <input id="pas2" class="registration__input" type="password" name="password_confirm"
                       placeholder="Repeat password"/>
                <i class="fas fa-eye fa-eye-slash icon-password"></i>
                <?php
                if (hasErrors('password_confirm')) {
                    foreach (getMessages('password_confirm') as $message) {
                        echo "<p class='registration__error'>" . $message . "</p>";
                    }
                    removeMessage('password_confirm');
                }
                ?>
                <div id="error"></div>
            </div>
            <button type="submit" class="registration__btn">Подтвердить</button>
        </form>
    </div>
</div>

<script src="../script.js"></script>
</body>
</html>