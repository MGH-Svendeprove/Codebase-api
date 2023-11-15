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
include_once('../../models/Reports.php');

/*
 * We are creating a database object which we now can get use of
 * in our models.
 */
$database = new Database();
$db = $database->connect();

$rp = new Reports($db);

if($_SERVER['REQUEST_METHOD'] === 'GET') {

    $data = $rp->select();

    if($data->rowCount()) {

        $reports = [];

        while($row = $data->fetch(PDO::FETCH_OBJ)) {

            $statusText = '';

            switch ($row->statusCode) {
                case 1:
                    $statusText = 'Pending';
                    break;
                case 2:
                    $statusText = 'Modified';
                    break;
                case 3:
                    $statusText = 'Deleted';
                    break;
            }

            $reports[] = [
                'report_id' => $row->report_id,
                'post_id' => $row->post_id,
                'subject' => $row->subject,
                'account_id' => $row->account_id,
                'subject' => $row->subject,
                'username' => openssl_decrypt($row->username, OPENSSL_CIPHERING, OPENSSL_ENCRYP_KEY, OPENSSL_OPTIONS, OPENSSL_ENCRYPT_IV),
                'report_datetime' => date("d.m.Y H:i:s", strtotime($row->report_datetime)),
                'reported' => $row->reported,
                'statusCode' => $row->statusCode,
                'statusText' => $statusText
            ];

        }

        echo json_encode($reports);

    } else {

        echo json_encode(['message' => 'No reports found...']);

    }

}