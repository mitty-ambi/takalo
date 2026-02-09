<?php
namespace app\models;

use PDO;

class Connection {
    public static function dbconnect() {
        try {
            $host ='127.0.0.1';
            $dbname = 'metis';
            $user = 'root';
            $password = ''; // Par défaut vide sur XAMPP

            $DBH = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
            $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $DBH;
        } catch (\PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}