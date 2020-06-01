<?php
require dirname(__DIR__) . '/inc/bootstrap.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === $config['username'] && password_verify($password, $config['password-hash'])) {
    $value = "$username\n{$config['password-hash']}";
} else {
    $value = 'invalid';
}

send_forever_cookie('auth', $value);
header('Location: /frame.php', true, 303);
