<?php require dirname(__DIR__) . '/inc/bootstrap.php' ?>
<!doctype html>
<html lang="en-GB">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Whiteboard</title>

        <link rel="stylesheet" href="<?= asset_url('frames.css') ?>">
        <link rel="icon" href="<?= asset_url('whiteboard.png') ?>">
        <link rel="manifest" href="<?= asset_url('manifest.json') ?>">

    </head>
    <body>
        <div class="container">
            <div class="column" style="flex: 2;">
                <iframe src="/frame.php?target=<?= urlencode($_GET['target'] ?? '') ?>&amp;m=<?= urlencode($_GET['m'] ?? '') ?>"
                    onload="this.contentDocument.querySelector('[autofocus]').focus()"></iframe>
            </div>
            <div class="column">
                <iframe src="/frame.php?target=<?= urlencode($_GET['target'] ?? '') ?>&amp;m=<?= urlencode("") ?>"></iframe>
                <iframe src="/frame.php?target=<?= urlencode($_GET['target'] ?? '') ?>&amp;m=<?= urlencode("") ?>"></iframe>
                <iframe src="/frame.php?target=<?= urlencode($_GET['target'] ?? '') ?>&amp;m=<?= urlencode("") ?>"></iframe>
            </div>
        </div>
    </body>
</html>
