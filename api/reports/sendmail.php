<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
 * Here we allow CORS origin, We are setting the content of the data
 * to be json, We allow all headers and all methods
 */
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
//header('Content-Type: text/html');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $mail_headers = array(
        'From' => 'Codebase',
        'Reply-To' => 'No reply',
        'X-Mailer' => 'PHP/' . phpversion()
    );

    mail($email, $subject, $message, $mail_headers);
}