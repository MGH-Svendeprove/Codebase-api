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
include_once('../../models/Posts.php');

/*
 * We are creating a database object which we now can get use of
 * in our models.
 */
$database = new Database();
$db = $database->connect();

$post = new Posts($db);

if($_SERVER['REQUEST_METHOD'] === 'GET') {

    if($post->delete($_GET['id'])) {
        echo json_encode(['message' => 'Post has been deleted']);
    } else {
        echo json_encode(['message' => 'Post could not be deleted']);
    }
}