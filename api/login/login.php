<?php

require('../../firebase/JWT/JWT.php');

use \Firebase\JWT\JWT;

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
include_once('../../models/Login.php');


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
$login = new Login($db);

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['email']) && isset($_GET['password'])) {
        $params = [
          'email' => openssl_encrypt(
              $_GET['email'],
              OPENSSL_CIPHERING,
              OPENSSL_ENCRYP_KEY,
              OPENSSL_OPTIONS,
              OPENSSL_ENCRYPT_IV),
            'password' => hash_hmac(
                'sha512',
                $_GET['password'],
                HASH_PASS_SECRET_KEY)
        ];

        $data = $login->login($params);

        if($data->rowCount()) {
            while($row = $data->fetch(PDO::FETCH_OBJ)) {
                $payload = [
                    'account_id' => $row->account_id,
                    'role' => $row->rolename,
                    'role_id' => $row->role_id
                ];
            }
           $jwt = JWT::encode(
               $payload,
               JWT_SECRET_KEY,
               'HS256');
            echo json_encode(['token' => $jwt]);
        } else {
            echo json_encode(['message' => 'Username or Password is incorrect']);
        }
    }
}