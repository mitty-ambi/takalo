<?php
namespace app\models;

class User
{
    public $id_user;
    public $nom;
    public $prenom;
    public $email;
    public $mdp_hash;
    public $type_user;

    public function __construct($nom = '', $prenom = '', $email = '', $mdp_hash = '', $type_user = 'normal', $id_user = null)
    {
        $this->id_user = $id_user;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->mdp_hash = $mdp_hash;
        $this->type_user = $type_user;
    }

    public function insert_user()
    {
        try {
            $DBH = \Flight::db();
            echo "[DEBUG] Connexion DB obtenue: " . get_class($DBH) . PHP_EOL;

            $sql = $DBH->prepare("INSERT INTO Utilisateur (nom,prenom,email,mdp_hash,type_user) VALUES (?,?,?,?,?)");
            echo "[DEBUG] Requete preparee" . PHP_EOL;

            $sql->bindValue(1, $this->nom, \PDO::PARAM_STR);
            $sql->bindValue(2, $this->prenom, \PDO::PARAM_STR);
            $sql->bindValue(3, $this->email, \PDO::PARAM_STR);
            $sql->bindValue(4, $this->mdp_hash, \PDO::PARAM_STR);
            $sql->bindValue(5, $this->type_user, \PDO::PARAM_STR);
            echo "[DEBUG] Valeurs liees (nom={$this->nom}, prenom={$this->prenom}, email={$this->email}, type={$this->type_user})" . PHP_EOL;

            $result = $sql->execute();
            echo "[DEBUG] Insertion reussie: " . ($result ? "OUI" : "NON") . PHP_EOL;
            return $result;
        } catch (\Exception $e) {
            echo "[DEBUG ERROR] " . $e->getMessage() . PHP_EOL;
            throw $e;
        }
    }
}
?>