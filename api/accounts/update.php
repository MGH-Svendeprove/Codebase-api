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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ori_file = $_FILES['file']['name'];
    $target_path = '../../assets/img/accounts/uploads/';
    $actual_fname = $_POST['username'] . '-' . $_FILES['file']['name'];
    $target_path = $target_path . $actual_fname;
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
        $params = [
            'username' => openssl_encrypt(
                $_POST['username'],
                OPENSSL_CIPHERING,
                OPENSSL_ENCRYP_KEY,
                OPENSSL_OPTIONS,
                OPENSSL_ENCRYPT_IV
            ),
            'picture' => $actual_fname,
            'account_id' => $_POST['account_id']
        ];

        if ($account->update($params)) {
            echo json_encode(['message' => 'Account has been updated']);
        } else {
            echo json_encode(['message' => 'Account could not be updated']);
        }
    }
}
