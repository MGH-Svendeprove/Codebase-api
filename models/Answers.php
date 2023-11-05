<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Answers {

    public $answer_id;
    public $account_id;
    public $post_id;
    public $content;
    public $answer_datetime;

    private $_table = 'cb_answers';
    private $_connection;

    public function __construct($db) {
        $this->_connection = $db;
    }

    public function insert($params) {
        try {

            $this->account_id = $params['account_id'];
            $this->post_id = $params['post_id'];
            $this->content = $params['content'];

            $query = 'INSERT INTO '.$this->_table.' SET
                      account_id = :account_id,
                      post_id = :post_id,
                      content = :content';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('account_id', $this->account_id);
            $stmt->bindValue('post_id', $this->post_id);
            $stmt->bindValue('content', $this->content);

            if($stmt->execute()) {
                return true;
            }

            return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function selectAll($post_id) {
        try {

            $this->post_id = $post_id;

            $query = 'SELECT a.username as username, 
                      c.answer_id, 
                      c.post_id, 
                      c.account_id,
                      c.content,
                      c.answer_datetime 
                      FROM '.$this->_table.' c 
                      LEFT JOIN cb_accounts a 
                      ON a.account_id = c.account_id 
                      WHERE post_id = :post_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('post_id', $this->post_id);
            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}