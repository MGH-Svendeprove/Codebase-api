<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Accounts {

    public $account_id;
    public $username;
    public $password;
    public $email;
    public $role_id;
    public $member_since;

    private $_table = 'cb_accounts';
    private $_connection;

    public function __construct($db) {
        $this->_connection = $db;
    }

    public function insert($params) {
        try {
            $this->username = $params['username'];
            $this->email = $params['email'];
            $this->password = $params['password'];
            $this->role_id = $params['role_id'];

            $query = 'INSERT INTO '.$this->_table.' SET 
                      username = :username,
                      password = :password,
                      email = :email,
                      role_id = :role_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('username', $this->username);
            $stmt->bindValue('email', $this->email);
            $stmt->bindValue('password', $this->password);
            $stmt->bindValue('role_id', $this->role_id);

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
            $this->account_id = $params['account_id'];
            $this->username = $params['username'];
            $this->email = $params['email'];
            $this->role_id = $params['role_id'];

            $query = 'UPDATE '.$this->_table.' SET 
                      username = :username,
                      email = :email,
                      role_id = :role_id WHERE
                      account_id = :account_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('username', $this->username);
            $stmt->bindValue('email', $this->email);
            $stmt->bindValue('password', $this->password);
            $stmt->bindValue('role_id', $this->role_id);
            $stmt->bincValue('account_id', $this->account_id);

            if($stmt->execute()) {
                return true;
            }

            return false;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function update_password($params) {
        try {

            $this->account_id = $params['account_id'];
            $this->password = $params['password'];

            $query = 'UPDATE '.$this->_table.' SET 
                      password = :password WHERE 
                      account_id = :account_id';
            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('account_id', $this->account_id);
            $stmt->bindValue('password', $this->password);

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
            $this->account_id = $id;

            $query = 'SELECT username,
                      email, role_id FROM '.$this->_table.' 
                      WHERE account_id = :account_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('account_id', $this->account_id);

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function selectAll() {
        try {

            $query = 'SELECT r.role_title as rolename,
                      a.username, a.email, a.role_id, a.member_since 
                      FROM '.$this->_table.' a LEFT JOIN 
                      cb_roles r ON r.role_id = a.role_id';

            $stmt = $this->_connection->prepare($query);

            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function checkAdmin() {
        try {

            $query = 'SELECT r.role_title as rolename,
                      a.username, a.email, a.role_id, a.member_since 
                      FROM '.$this->_table.' a LEFT JOIN 
                      cb_roles r ON r.role_id = a.role_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->execute();

            return $stmt;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function delete($id) {
        try {

            $this->account_id = $id;

            $query = 'DELETE FROM '.$this->_table.' WHERE
                      account_id = :account_id';

            $stmt = $this->_connection->prepare($query);
            $stmt->bindValue('account_id', $this->account_id);

            if($stmt->execute()) {
                return true;
            }

            return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}