<?php
namespace app\models;

use app\models\Connection;

class MessageFille{
    public $id_message;
    public $user_from;
    public $user_to;
    public $content;
    public $date_envoi;

    public function __construct($id_message = null, $user_from = '', $user_to = '', $content = '', $date_envoi = null) {
        $this->id_message = $id_message;
        $this->user_from = $user_from;
        $this->user_to = $user_to;
        $this->content = $content;
        $this->date_envoi = $date_envoi ?? date('Y-m-d H:i:s');
    }

    /**
     * Envoyer un message
     * @return bool|int ID du message créé ou false
     */
    public function envoyer(){
        $DBH = Connection::dbconnect();
        
        $stmt = $DBH->prepare("INSERT INTO Message_fille (id_message, user_from, user_to, content, date_envoi) VALUES (?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $this->id_message);
        $stmt->bindParam(2, $this->user_from);
        $stmt->bindParam(3, $this->user_to);
        $stmt->bindParam(4, $this->content);
        $stmt->bindParam(5, $this->date_envoi);
        
        if($stmt->execute()) {
            return $DBH->lastInsertId();
        }
        return false;
    }

    /**
     * Obtenir tous les messages d'une conversation
     * @param int $id_message
     * @return array
     */
    public function obtenir_messages($id_message){
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("SELECT * FROM Message_fille WHERE id_message = ? ORDER BY date_envoi ASC");
        $stmt->bindParam(1, $id_message);
        
        if($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return [];
    }

    /**
     * Obtenir les derniers messages d'une conversation
     * @param int $id_message
     * @param int $limite
     * @return array
     */
    public function obtenir_derniers_messages($id_message, $limite = 50){
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("SELECT * FROM Message_fille WHERE id_message = ? ORDER BY date_envoi DESC LIMIT ?");
        $stmt->bindParam(1, $id_message);
        $stmt->bindParam(2, $limite, \PDO::PARAM_INT);
        
        if($stmt->execute()) {
            $messages = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return array_reverse($messages);
        }
        return [];
    }

    /**
     * Supprimer un message
     * @param int $id_message
     * @return bool
     */
    public function supprimer($id_message){
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("DELETE FROM Message_fille WHERE id_message = ?");
        $stmt->bindParam(1, $id_message);
        
        return $stmt->execute();
    }

    /**
     * Obtenir les messages non lus
     * @param string $user_to
     * @return int
     */
    public function obtenir_non_lus($user_to){
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("SELECT COUNT(*) as count FROM Message_fille WHERE user_to = ?");
        $stmt->bindParam(1, $user_to);
        
        if($stmt->execute()) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['count'];
        }
        return 0;
    }
}
?>
