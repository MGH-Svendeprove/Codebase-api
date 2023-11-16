<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

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
        echo json_encode(['message' => 'Something went wrong, please try again!']);
    }
}
