<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Categories {

    public $category_id;
    public $cat_title;
    public $cat_picture;

    private $_connection;
    private $_table = "cb_categories";
    private $_posts_table = "cb_posts";

    public function __construct($db) {
        $this->_connection = $db;
    }

    public function insert($params) {
        try {

            $this->cat_title = $params['cat_title'];
            $this->cat_picture = $params['cat_picture'];

            $query = 'INSERT INTO '.$this->_table.' SET
                      cat_title = :cat_title,
                      cat_picture = :cat_picture';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('cat_title', $this->cat_title);
            $stmt->bindValue('cat_picture', $this->cat_picture);

            if($stmt->execute()) {
                return true;
            }

            return false;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update($params) {
        try {

            $this->category_id = $params['category_id'];
            $this->cat_title = $params['cat_title'];
            $this->cat_picture = $params['cat_picture'];

            $query = 'UPDATE '.$this->_table.' SET 
                      cat_title = :cat_title,
                      cat_picture = :cat_picture
                      WHERE category_id = :category_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('category_id', $this->category_id);
            $stmt->bindValue('cat_title', $this->cat_title);
            $stmt->bindValue('cat_picture', $this->cat_picture);

            if($stmt->execute()) {
                return true;
            }

            return false;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function selectAll() {
        try {

            $query = 'SELECT * FROM '.$this->_table;

            $stmt = $this->_connection->prepare($query);
            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function count_posts_categories($category_id) {
        try {
            $this->category_id = $category_id;

            $query = 'SELECT * FROM '.$this->_posts_table.' 
                      WHERE category_id = :category_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('category_id', $this->category_id);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function select($id) {
        try {

            $this->category_id = $id;

            $query = 'SELECT * from '.$this->_table.' WHERE category_id = :category_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('category_id', $this->category_id);
            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


}