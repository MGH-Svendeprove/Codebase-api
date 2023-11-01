<?php

/*
 * We will here require the settings, so we can get the information
 * make the connection to the database, all data will be stored in
 * private variables, so we can't alter them from outside the class
 */

require_once('settings.php');

class Database {

    private $_host = DB_HOST;
    private $_database = DB_NAME;
    private $_username = DB_USER;
    private $_password = DB_PASS;
    private $_connection = null;

    // The connection function will be public, so we can use it other
    // places in the api. We are making the connection inside a try/catch
    // so if the connection fail, then we will catch an exception which
    // tells us what is wrong with the connection.
    public function connect() {
        try {
            $this->_connection = new PDO('mysql:host='.$this->_host.';dbname='.$this->_database, $this->_username, $this->_password);
            //echo 'Database connection is working.';
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $this->_connection;
    }

}