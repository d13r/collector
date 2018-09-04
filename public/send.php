<?php
require dirname(__DIR__) . '/inc/bootstrap.php';

// Helpers
function send_json($json)
{
    header('Content-Type: application/json');
    echo json_encode($json);
    exit;
}

function send_error($message)
{
    send_json(['error' => $message]);
}

// Check authentication
if (!logged_in()) {
    send_error('You are not logged in. Please refresh the page and try again');
}

// Parse message
$message = trim($_POST['message'] ?? '');

if (!$message) {
    send_error('Please enter a message');
}

$message = str_replace(["\r\n", "\r"], "\n", $message);

$parts = explode("\n", $message, 2);

if (count($parts) === 1) {
    $subject = $parts[0];
    $message = '';
} else {
    [$subject, $message] = $parts;
}

// Send email
mail($config['to'], $subject, $message, "From: {$config['from']}");
send_json(['success' => 'Message sent']);
