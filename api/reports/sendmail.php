<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $mail_headers = array(
        'From' => 'Codebase',
        'Reply-To' => 'No reply',
        'X-Mailer' => 'PHP/' . phpversion()
    );

    if (mail($email, $subject, $message, $mail_headers)) {
        echo json_encode(['message' => 'Email has been sent']);
    } else {
        echo json_encode(['message' => 'Something went wrong while sending the mail, please try again!']);
    }
}
