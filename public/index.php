<?php require dirname(__DIR__) . '/inc/bootstrap.php' ?>
<!doctype html>
<html lang="en-GB">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Collector</title>

        <link rel="stylesheet" href="<?= asset_url('main.css') ?>">
        <link rel="shortcut icon" href="<?= asset_url('favicon.ico') ?>">

    </head>
    <body>

        <?php if (logged_in()): ?>

            <!-- Main page -->
            <form class="form">
                <div class="message-row">
                    <textarea name="message" class="message" autofocus></textarea>
                </div>
                <div class="buttons-row">
                    <button class="submit button">Send</button>
                </div>
                <div class="confirmation">Message Sent</div>
            </form>
            <script src="<?= asset_url('main.js') ?>"></script>

        <?php else: ?>

            <!-- Login -->
            <div class="login-container">
                <form class="login" action="/login.php" method="post">
                    <div class="login-field">
                        <input name="username" type="text" placeholder="Username" autofocus>
                    </div>
                    <div class="login-field">
                        <input name="password" type="password" placeholder="Password">
                    </div>
                    <div class="login-button">
                        <button type="submit">Log In</button>
                    </div>
                </form>
            </div>

        <?php endif ?>

    </body>
</html>
