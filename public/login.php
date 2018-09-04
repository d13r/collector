<?php
require dirname(__DIR__) . '/inc/bootstrap.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === $config['username'] && password_verify($password, $config['password-hash'])) {
    $value = "$username\n{$config['password-hash']}";
} else {
    $value = 'invalid';
}

setcookie('auth', $value, 2147483647, '/', '', true, true);
header('Location: /', true, 303);
