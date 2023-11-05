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


    $params = [
        'old_password' => hash_hmac(
            'sha512', $_POST['old_password'],
            HASH_PASS_SECRET_KEY
        ),
        'password' => hash_hmac(
            'sha512',
            $_POST['password'],
            HASH_PASS_SECRET_KEY
        ),
        'account_id' => $_POST['account_id']
    ];

    if($account->check_password($params)) {
        if ($account->update_password($params)) {
            echo json_encode(['message' => 'Password has been updated']);
        } else {
            echo json_encode(['message' => 'Password could not be updated']);
        }
    } else {
        echo json_encode(['message' => 'Password was not a match']);
    }


}