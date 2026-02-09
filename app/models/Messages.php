<?php
namespace app\models;

use app\models\Connection;

class Messages{
    public $id;
    public $user_1;
    public $user_2;

    public function __construct($id = null, $user_1 = '', $user_2 = '') {
        $this->id = $id;
        $this->user_1 = $user_1;
        $this->user_2 = $user_2;
    }

    /**
     * Créer une nouvelle conversation
     * @return bool|int 
     */
    public function creer(){
        $DBH = Connection::dbconnect();
        
        $existante = $this->obtenir_conversation($this->user_1, $this->user_2);
        if($existante) {
            return $existante['id'];
        }
        
        $stmt = $DBH->prepare("INSERT INTO Messages (user_1, user_2) VALUES (?, ?)");
        $stmt->bindParam(1, $this->user_1);
        $stmt->bindParam(2, $this->user_2);
        
        if($stmt->execute()) {
            return $DBH->lastInsertId();
        }
        return false;
    }

    /**
     * Obtenir une conversation entre deux utilisateurs
     * @param string $user_1
     * @param string $user_2
     * @return array|false
     */
    public function obtenir_conversation($user_1, $user_2){
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("SELECT * FROM Messages WHERE (user_1 = ? AND user_2 = ?) OR (user_1 = ? AND user_2 = ?)");
        $stmt->bindParam(1, $user_1);
        $stmt->bindParam(2, $user_2);
        $stmt->bindParam(3, $user_2);
        $stmt->bindParam(4, $user_1);
        
        if($stmt->execute()) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * Obtenir toutes les conversations d'un utilisateur
     * @param string $username
     * @return array
     */
    public function obtenir_conversations($username){
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("SELECT * FROM Messages WHERE user_1 = ? OR user_2 = ? ORDER BY id DESC");
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $username);
        
        if($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return [];
    }

    /**
     * Obtenir une conversation par ID
     * @param int $id
     * @return array|false
     */
    public function obtenir_par_id($id){
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("SELECT * FROM Messages WHERE id = ?");
        $stmt->bindParam(1, $id);
        
        if($stmt->execute()) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * Supprimer une conversation
     * @param int $id
     * @return bool
     */
    public function supprimer($id){
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("DELETE FROM Messages WHERE id = ?");
        $stmt->bindParam(1, $id);
        
        return $stmt->execute();
    }

    /**
     * Obtenir TOUTES les conversations (sans filtrage utilisateur)
     * @return array
     */
    public function obtenir_toutes(){
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("SELECT * FROM Messages ORDER BY id DESC");
        
        if($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return [];
    }
}
?>
