<?php

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

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

// Check target
$targetId = $_POST['target'] ?? '';

if (!isset($config['targets'][$targetId])) {
    send_error('No target selected');
}

$target = $config['targets'][$targetId];

send_forever_cookie('target', $targetId);

// Parse message
$message = trim($_POST['message'] ?? '');

if (!$message) {
    send_error('Please enter a message');
}

$message = str_replace(["\r\n", "\r"], "\n", $message);

$parts = explode("\n", $message, 2);

if (count($parts) === 1) {
    $subject = $message;
    $message = '';
} else {
    $subject = trim($parts[0]);
    $message = trim($parts[1]);
}

// Send email
$email = (new Email());
$email->returnPath(Address::create($target['return']));
$email->from(Address::create($target['from']));
$email->to(...Address::createArray( $target['to']));
$email->subject($subject);
$email->text($message);

if ($target['replyto'] ?? null) {
    $email->replyTo(...Address::createArray($target['replyto']));
}

$transport = Transport::fromDsn('sendmail://default');
$mailer = new Mailer($transport);
$mailer->send($email);

// Send response
send_json(['success' => 'Message Sent']);
