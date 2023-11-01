<?php

/*
 * Here outside the class we are going to make some settings for
 * displaying errors.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
 * In this class we handle all with the login
 */
class Login {

    public $email;
    public $password;

    private $_table = 'cb_accounts';
    private $_connection;

    public function __construct($db) {
        $this->_connection = $db;
    }

    public function login($params) {
        try {

            $this->email = $params['email'];
            $this->password = $params['password'];

            $query = 'SELECT r.role_title as rolename,
                      a.account_id FROM '.$this->_table.' a LEFT JOIN
                      cb_roles r ON r.role_id = a.role_id WHERE
                      a.email = :email AND a.password = :password
                      LIMIT 0,1';

            $stmt = $this->_connection->prepare($query);

            $stmt->bindValue('email', $this->email);
            $stmt->bindValue('password', $this->password);

            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}