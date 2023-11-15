<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Reports {

    public $report_id;
    public $post_id;
    public $account_id;
    public $subject;
    public $report_datetime;
    public $reported;
    public $statusCode;

    private $_table = 'cb_reports';

    private $_connection;

    public function __construct($db) {
        $this->_connection = $db;
    }

    public function insert($params) {
        try {

            $this->post_id = $params['post_id'];
            $this->account_id = $params['account_id'];
            $this->reported = $params['reported'];
            $this->subject = $params['subject'];
            $this->statusCode = $params['statusCode'];

            $query = 'INSERT INTO ' .$this->_table.' SET 
                      post_id = :post_id,
                      account_id = :account_id,
                      reported = :reported,
                      subject = :subject,
                      statusCode = :statusCode';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('post_id', $this->post_id);
            $stmt->bindValue('account_id', $this->account_id);
            $stmt->bindValue('reported', $this->reported);
            $stmt->bindValue('subject', $this->subject);
            $stmt->bindValue('statusCode', $this->statusCode);

            if($stmt->execute()) {
                return true;
            }

            return false;

        } catch (PDOException $e) {

            echo $e->getMessage();

        }
    }

    public function select() {
        try {

            $query = 'SELECT a.username as username,
                     r.report_datetime, r.report_id, 
                     r.account_id, r.post_id, 
                     r.reported, r.subject, 
                     r.statusCode FROM
                     '.$this->_table.' r 
                     LEFT JOIN cb_accounts a ON
                     a.account_id = r.account_id 
                     LEFT JOIN cb_posts p ON 
                     p.post_id = r.post_id ORDER BY 
                     r.report_datetime DESC';

            $stmt = $this->_connection->prepare($query);
            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {

            echo $e->getMessage();

        }
    }

    public function counter() {
        try {

            $query = 'SELECT * FROM '.$this->_table.' WHERE reported = :reported';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('reported', "no");
            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {

            echo $e->getMessage();

        }

    }

    public function countAll() {
        try {

            $query = 'SELECT * FROM '.$this->_table;

            $stmt = $this->_connection->prepare($query);
            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {

            echo $e->getMessage();

        }
    }

    public function update($params) {
        try {

            $this->statusCode = $params['statusCode'];
            $this->report_id = $params['report_id'];
            $this->reported = $params['reported'];

            $query = 'UPDATE '.$this->_table.' SET 
                      statusCode = :statusCode,
                      reported = :reported WHERE 
                      report_id = :report_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('statusCode', $this->statusCode);
            $stmt->bindValue('report_id', $this->report_id);
            $stmt->bindValue('reported', $this->reported);

            if($stmt->execute()) {
                return true;
            }

            return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


}