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

if($_SERVER['REQUEST_METHOD'] === 'GET') {

    $data = $ans->selectAll($_GET['id']);

    if($data->rowCount()) {

        $answer = [];

        while($row = $data->fetch(PDO::FETCH_OBJ)) {
            $answer[] = [
                'account_id' => $row->account_id,
                'username' => openssl_decrypt(
                    $row->username,
                    OPENSSL_CIPHERING,
                    OPENSSL_ENCRYP_KEY,
                    OPENSSL_OPTIONS,
                    OPENSSL_ENCRYPT_IV),
                'post_id' => $row->post_id,
                'content' => $row->content,
                'answer_datetiome' => $row->answer_datetime
            ];
        }

        echo json_encode($answer);
    }

    echo json_encode(['message' => 'There is now answers to this post yet']);
}