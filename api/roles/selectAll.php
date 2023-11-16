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
include_once('../../models/Roles.php');

/*
 * We are creating a database object which we now can get use of
 * in our models.
 */
$database = new Database();
$db = $database->connect();

$role = new Roles($db);

if($_SERVER['REQUEST_METHOD'] === 'GET') {

    $data = $role->selectAll();

    if($data->rowCount()) {

        $roles = [];

        while($row = $data->fetch(PDO::FETCH_OBJ)) {
            $roles[] = [
                'role_id' => $row->role_id,
                'role_title' => $row->role_title
            ];
        }

        echo json_encode($roles);
    } else {
        echo json_encode(['message' => 'No roles in the system']);
    }
}