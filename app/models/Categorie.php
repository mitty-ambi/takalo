<?php
class Categorie
{
    public $id_categorie;
    public $nom_categorie;

    public function __construct($id_categorie = null, $nom_categorie = null)
    {
        $this->id_categorie = $id_categorie;
        $this->nom_categorie = $nom_categorie;
    }
    public function insert()
    {
        $DBH = Connection::dbconnect();
        $stmt = $DBH->prepare("INSERT INTO categorie (nom_categorie) VALUES (:nom_categorie)");
        $stmt->bindParam(':nom_categorie', $this->nom_categorie);
        return $stmt->execute();
    }
}
?>