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