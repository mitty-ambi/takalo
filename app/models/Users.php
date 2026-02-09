<?php
namespace app\models;

use app\models\Connection;

class Users
{
    public $username;
    public $email;
    public $mot_de_passe;

    public function __construct($username = '', $email = '', $mot_de_passe = '')
    {
        $this->username = $username;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
    }

    /**
     * Valider les identifiants de connexion
     * @return bool 
     */
    public function valider_login($username, $email, $mot_de_passe)
    {
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("SELECT * FROM User WHERE username = ? AND email = ? AND mot_de_passe = ?");
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $mot_de_passe);

        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result ? true : false;
        }
        return false;
    }

    /**
     * Enregistrer un nouvel utilisateur
     * @return bool 
     */
    public function enregistrer()
    {
        $DBH = Connection::dbconnect();

        if ($this->existe()) {
            return false;
        }

        $stmt = $DBH->prepare("INSERT INTO User (username, email, mot_de_passe) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $this->username);
        $stmt->bindParam(2, $this->email);
        $stmt->bindParam(3, $this->mot_de_passe);

        return $stmt->execute();
    }

    /**
     * Vérifier si un utilisateur existe déjà
     * @return bool
     */
    public function existe()
    {
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("SELECT COUNT(*) as count FROM User WHERE username = ? OR email = ?");
        $stmt->bindParam(1, $this->username);
        $stmt->bindParam(2, $this->email);

        if ($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        }
        return false;
    }

    /**
     * Obtenir un utilisateur par username
     * @param string $username
     * @return array|false
     */
    public function obtenir_par_username($username)
    {
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("SELECT * FROM User WHERE username = ?");
        $stmt->bindParam(1, $username);

        if ($stmt->execute()) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * Obtenir un utilisateur par email
     * @param string $email
     * @return array|false
     */
    public function obtenir_par_email($email)
    {
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("SELECT * FROM User WHERE email = ?");
        $stmt->bindParam(1, $email);

        if ($stmt->execute()) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * Mettre à jour un utilisateur
     * @return bool
     */
    public function mettre_a_jour()
    {
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("UPDATE User SET email = ?, mot_de_passe = ? WHERE username = ?");
        $stmt->bindParam(1, $this->email);
        $stmt->bindParam(2, $this->mot_de_passe);
        $stmt->bindParam(3, $this->username);

        return $stmt->execute();
    }

    /**
     * Supprimer un utilisateur
     * @param string $username
     * @return bool
     */
    public function supprimer($username)
    {
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("DELETE FROM User WHERE username = ?");
        $stmt->bindParam(1, $username);
        return $stmt->execute();
    }

    /**
     * Obtenir tous les utilisateurs
     * @return array
     */
    public function obtenir_tous()
    {
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("SELECT username, email FROM User");

        if ($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return [];
    }
}
?>