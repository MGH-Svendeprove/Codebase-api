<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Roles {

    private $_connection;
    private $_table = 'cb_roles';

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
}