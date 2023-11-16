<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Posts {

    public $post_id;
    public $account_id;
    public $category_id;
    public $subject;
    public $content;
    public $post_datetime;

    private $_table = 'cb_posts';
    private $_connection;

    public function __construct($db) {
        $this->_connection = $db;
    }

    public function insert($params) {
        try {
            $this->account_id = $params['account_id'];
            $this->category_id = $params['category_id'];
            $this->subject = $params['subject'];
            $this->content = $params['content'];

            $query = 'INSERT INTO '.$this->_table.' SET 
                      account_id = :account_id,
                      category_id = :category_id,
                      subject = :subject,
                      content = :content';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('account_id', $this->account_id);
            $stmt->bindValue('category_id', $this->category_id);
            $stmt->bindValue('subject', $this->subject);
            $stmt->bindValue('content', $this->content);

            if($stmt->execute()) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update($params) {
        try {
            $this->post_id = $params['post_id'];
            $this->account_id = $params['account_id'];
            $this->category_id = $params['category_id'];
            $this->subject = $params['subject'];
            $this->content = $params['content'];

            $query = 'UPDATE '.$this->_table.' SET 
                      account_id = :account_id,
                      category_id = :category_id,
                      subject = :subject,
                      content = :content WHERE
                      post_id = :post_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('post_id', $this->post_id);
            $stmt->bindValue('account_id', $this->account_id);
            $stmt->bindValue('category_id', $this->category_id);
            $stmt->bindValue('subject', $this->subject);
            $stmt->bindValue('content', $this->content);

            if($stmt->execute()) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function select($id) {
        try {

            $this->post_id = $id;

            $query = 'SELECT a.username as username,
                      p.post_id, p.account_id, p.category_id, 
                      p.subject, p.content, p.post_datetime, a.username  
                      FROM '.$this->_table.' p LEFT JOIN cb_accounts a
                      ON a.account_id = p.account_id
                      WHERE post_id = :post_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('post_id', $this->post_id);
            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function selectAll($category_id) {
        try {

            $this->category_id = $category_id;

            $query = 'SELECT a.username as username,
                      p.post_id, p.account_id, 
                      p.subject, p.content, p.post_datetime
                      FROM '.$this->_table.' p 
                      LEFT JOIN cb_accounts a ON
                      a.account_id = p.account_id  
                      WHERE category_id = :category_id 
                      ORDER BY p.post_datetime DESC';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('category_id', $this->category_id);
            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function countAnswers($post_id) {
        try {

            $this->post_id = $post_id;

            $query = 'SELECT * FROM cb_answers WHERE post_id = :post_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('post_id', $this->post_id);
            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {

            echo $e->getMessage();

        }
    }

    public function latestPosts() {
        try {

            $query = 'SELECT a.username as username,
                      p.post_id, p.account_id, 
                      p.subject, p.content, p.post_datetime
                      FROM '.$this->_table.' p 
                      LEFT JOIN cb_accounts a ON
                      a.account_id = p.account_id  
                      LEFT JOIN cb_categories c 
                      ON c.category_id = p.category_id 
                      ORDER BY p.post_datetime DESC
                      LIMIT 5';

            $stmt = $this->_connection->prepare($query);
            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function myPosts($account_id) {
        try {
            $this->account_id = $account_id;

            $query = 'SELECT c.cat_title as category, 
                      p.post_id, p.account_id, p.category_id, 
                      p.subject, p.post_datetime 
                      FROM '.$this->_table.' p 
                      LEFT JOIN cb_categories c  
                      ON c.category_id = p.category_id
                      WHERE account_id = :account_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('account_id', $this->account_id);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function delete($id) {
        try {

            $this->post_id = $id;

            $query = 'DELETE FROM '.$this->_table.' WHERE post_id = :post_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('post_id', $this->post_id);

            if($stmt->execute()) {

                $query1 = 'DELETE FROM answers WHERE post_id = :posts_id';
                $stmt1 = $this->_connection->prepare($query1);
                $stmt1->bindValue('posts_id', $this->post_id);

                if($stmt1->execute()) {

                    return true;

                }
            }

            return false;

        } catch (PDOException $e) {

            echo $e->getMessage();

        }
    }

    public function countAllPosts() {
        try {

            $query = 'SELECT * FROM '.$this->_table;

            $stmt = $this->_connection->prepare($query);
            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}