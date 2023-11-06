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

    $data = $post->select($_GET['id']);

    if($data->rowCount()) {

        $posts = [];

        while($row = $data->fetch(PDO::FETCH_OBJ)) {
            $posts = [
                'post_id' => $row->post_id,
                'account_id' => $row->account_id,
                'category_id' => $row->category_id,
                'username' => openssl_decrypt(
                    $row->username,
                    OPENSSL_CIPHERING,
                    OPENSSL_ENCRYP_KEY,
                    OPENSSL_OPTIONS,
                    OPENSSL_ENCRYPT_IV),
                'subject' => $row->subject,
                'content' => $row->content,
                'post_datetime' => date("d.m.Y H:i:s", strtotime($row->post_datetime))
            ];
        }

        echo json_encode($posts);

    } else {
        echo json_encode(['message' => 'post does not exists in the system']);
    }


}