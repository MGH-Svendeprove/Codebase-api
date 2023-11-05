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

include_once('../../config/Database.php');
include_once('../../config/settings.php');
include_once('../../models/Answers.php');

/*
 * We are creating a database object which we now can get use of
 * in our models.
 */
$database = new Database();
$db = $database->connect();

$ans = new Answers($db);

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $params = [
        'account_id' => $_POST['account_id'],
        'post_id' => $_POST['post_id'],
        'content' => $_POST['content']
    ];

    if($ans->insert($params)) {
        echo json_encode(['message' => 'Answer has been added to the post']);
    } else {
        echo json_encode(['message' => 'something went wrong, please try again']);
    }

}