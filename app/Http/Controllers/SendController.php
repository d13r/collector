<?php

namespace App\Http\Controllers;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class SendController extends Controller
{
    public function __invoke()
    {
        $config = config('collector');

        // Check authentication
        if (!logged_in()) {
            return ['error' => 'You are not logged in. Please refresh the page and try again'];
        }

        // Check target
        $targetId = $_POST['target'] ?? '';

        if (!isset($config['targets'][$targetId])) {
            return ['error' => 'No target selected'];
        }

        $target = $config['targets'][$targetId];

        send_forever_cookie('target', $targetId);

        // Parse message
        $message = trim($_POST['message'] ?? '');

        if (!$message) {
            return ['error' => 'Please enter a message'];
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
        return ['success' => 'Message Sent'];
    }
}
