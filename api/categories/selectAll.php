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
include_once('../../models/Categories.php');

/*
 * We are creating a database object which we now can get use of
 * in our models.
 */
$database = new Database();
$db = $database->connect();

$cats = new Categories($db);

if($_SERVER['REQUEST_METHOD'] === 'GET') {

    $data = $cats->selectAll();

    if($data->rowCount()) {
        $categories = [];
        while($row = $data->fetch(PDO::FETCH_OBJ)) {
            $postsData = $cats->count_posts_categories($row->category_id);
            $categories[] = [
                'category_id' => $row->category_id,
                'cat_title' => $row->cat_title,
                'cat_picture' => $row->cat_picture,
                'cat_counter' => $postsData->rowCount()
            ];
        }

        echo json_encode($categories);
    } else {
        echo json_encode(['message' => 'There is no categories']);
    }
}