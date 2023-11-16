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

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ori_file = $_FILES['file']['name'];
    $target_path = '../../assets/img/categories/';
    $actual_fname = $_FILES['file']['name'];
    $target_path = $target_path . $actual_fname;
    if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {

        $params = [
            'cat_title' => $_POST['cat_title'],
            'cat_picture' => $actual_fname
        ];

        if($cats->insert($params)) {
            $lastInsertId = $db->lastInsertId();
            $data = $cats->select($lastInsertId);
            if($data->rowCount()) {
                $category = [];
                while($row = $data->fetch(PDO::FETCH_OBJ)) {
                    $category = [
                      'category_id' => $row->category_id,
                      'cat_title' => $row->cat_title,
                      'cat_picture' => $row->cat_picture
                    ];
                }
                echo json_encode($category);
            }
        } else {
            echo json_encode(['message' => 'Category could not be created']);
        }

    }

}