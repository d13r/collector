<!doctype html>
<html lang="en-GB">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Collector</title>

        <link rel="stylesheet" href="<?= asset_url('main.css') ?>">
        <link rel="icon" href="<?= asset_url('favicon.ico') ?>">
        <link rel="manifest" href="<?= asset_url('manifest.json') ?>">

        <style>
            <?php foreach ($config['targets'] as $id => $target): if ($target['color'] ?? null): ?>
                .message[data-target="<?= e($id) ?>"]::first-line {
                    color: <?= e($target['color']) ?>;
                }
            <?php endif; endforeach ?>
        </style>

    </head>
    <body>

        <?php if (logged_in()): ?>

            <!-- Main page -->
            <form class="form">

                <!-- Message -->
                <div class="message-row">
                    <textarea name="message" class="message" autofocus placeholder="Collector" spellcheck="false"><?= "\n" . e($_GET['message'] ?? '') ?></textarea>
                </div>

                <div class="buttons-row">

                    <!-- Target -->
                    <?php if (count($config['targets']) > 1): ?>
                        <div class="targets">
                            <?php foreach ($config['targets'] as $id => $target): ?>
                                <label class="target">
                                    <input
                                        data-to="{{ implode(', ', $target['to']) }}"
                                        type="radio"
                                        name="target"
                                        value="<?= e($id) ?>"
                                        accesskey="<?= e($target['shortcut']) ?>"
                                        tabindex="-1"
                                        <?= checked(is_current_target($id)) ?>
                                    >
                                    <span class="target-text"><?= e($target['title']) ?></span>
                                </label>
                            <?php endforeach ?>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="target" value="<?= e(current_target()) ?>">
                    <?php endif ?>

                    <!-- Send -->
                    <button class="submit button" tabindex="-1">Send</button>

                </div>

                <!-- Confirmation -->
                <div class="confirmation">Message Sent</div>

            </form>
            <script src="<?= asset_url('main.js') ?>"></script>

        <?php else: ?>

            <!-- Login -->
            <div class="login-container">
                <form class="login" action="/login" method="post">
                    <div class="login-field">
                        <input name="username" type="text" placeholder="Username" autofocus>
                    </div>
                    <div class="login-field">
                        <input name="password" type="password" placeholder="Password">
                    </div>
                    <div class="login-button">
                        <button type="submit">Log In</button>
                    </div>
                    @csrf
                </form>
            </div>

        <?php endif ?>

    </body>
</html>
