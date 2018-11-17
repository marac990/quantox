<?php

namespace Quantox\Repositories;

use PDO;
use Quantox\DB;

class UserRepository

{
    protected $db;

    public function __construct()
    {
        $this->db = DB::getInstance()->getConnection();
    }

    public function getUser($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e;
        }

        return $user;
    }

    public function getUserIfLoggedIn()
    {
        if (!empty($_SESSION['user_id'])) {
            return $this->getUser( $_SESSION['user_id'] );
        } else {
            return false;
        }
    }

    public function getUserByEmailAndPassword( $email, $password )
    {
        $password = md5( $password );
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e;
        }

        return $user;
    }

    public function getUsers( $keyword )
    {
        $keyword = '%' . $keyword . '%';

        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE firstname LIKE :keyword");
            $stmt->bindParam(':keyword', $keyword);
            $stmt->execute();
            $users = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e;
        }
        return $users ? $users : false;
    }

    public function saveUser($params)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $params['email']);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return $e;
        }
        if ( $user['id'] && $user  ) {
            return false;
        }
        $params['password'] = md5( $params['password'] );
        try {
            $stmt = $this->db->prepare("INSERT INTO users ( email, password, firstname, lastname) VALUES ( :email, :password, :name, :lastname)");
            $stmt->bindParam(':name', $params['name']);
            $stmt->bindParam(':lastname', $params['lastname']);
            $stmt->bindParam(':email', $params['email']);
            $stmt->bindParam(':password', $params['password']);
            $stmt->execute();
        } catch (\PDOException $exception) {
            return $exception;
        }

        return $this->db->lastInsertId();
    }
}