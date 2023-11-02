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
include_once('../../models/Accounts.php');

/*
 * We are creating a database object which we now can get use of
 * in our models.
 */
$database = new Database();
$db = $database->connect();

/*
 * We are creating an object of our Account model, so we can work
 * with the functions inside the model. And we are using our Database
 * object as a parameter in our Accounts model. because we made the
 * constructor which has to get a parameter, That parameter has to be the
 * Database connection.
 */
$account = new Accounts($db);

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data = $account->select($_GET['id']);

    if($data->rowCount()) {
        $usr = [];
        while($row = $data->fetch(PDO::FETCH_OBJ)) {
            $usr = [
                'username' => openssl_decrypt(
                    $row->username,
                    OPENSSL_CIPHERING,
                    OPENSSL_ENCRYP_KEY,
                    OPENSSL_OPTIONS,
                    OPENSSL_ENCRYPT_IV
                ),
                'email' => openssl_decrypt(
                    $row->email,
                    OPENSSL_CIPHERING,
                    OPENSSL_ENCRYP_KEY,
                    OPENSSL_OPTIONS,
                    OPENSSL_ENCRYPT_IV
                ),
                'role_id' => $row->role_id,
                'picture' => $row->picture
            ];
        }

        echo json_encode($usr);
    } else {
        echo json_encode(['message' => 'There is no data to show.']);
    }
}