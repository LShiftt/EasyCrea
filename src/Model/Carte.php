<?php

declare(strict_types=1);

namespace App\Model;

class Carte extends Model
{
    use TraitInstance;

    protected $tableName = APP_TABLE_PREFIX . 'carte';
    protected $tableNameRng = APP_TABLE_PREFIX . 'carte_aleatoire';

    public function createCarte(
        string $texte,
        string $val1,
        string $val2,
        string $date,
        int $ordre,
        int $idCreateur,
        int $idDeck
    ) {
        $sql = "INSERT INTO `{$this->tableName}` (texte_carte, valeurs_choix1, valeurs_choix2, date_soumission, ordre_soumission, id_createur, id_deck) 
        VALUES (:texte, :val1, :val2, :date, :ordre, :idCreateur, :idDeck)";
        $sth = $this->query($sql, [
            ':texte' => $texte,
            ':val1' => $val1,
            ':val2' => $val2,
            ':date' => $date,
            ':ordre' => $ordre,
            ':idCreateur' => $idCreateur,
            ':idDeck' => $idDeck
        ]);
        return $sth ? true : false;
    }
    public function createCarteAdmin(
        string $texte,
        string $val1,
        string $val2,
        string $date,
        int $ordre,
        int $idAdmin,
        int $idDeck
    ) {
        $sql = "INSERT INTO `{$this->tableName}` (texte_carte, valeurs_choix1, valeurs_choix2, date_soumission, ordre_soumission, id_administrateur , id_deck) 
        VALUES (:texte, :val1, :val2, :date, :ordre, :idAdmin, :idDeck)";
        $sth = $this->query($sql, [
            ':texte' => $texte,
            ':val1' => $val1,
            ':val2' => $val2,
            ':date' => $date,
            ':ordre' => $ordre,
            ':idAdmin' => $idAdmin,
            ':idDeck' => $idDeck
        ]);
        return $sth ? true : false;
    }
    public function getCarteRng($idDeck, $idCreateur)
    {
        $sql = "SELECT num_carte FROM `{$this->tableNameRng}` WHERE id_deck = :idDeck && id_createur = :idCreateur";
        $sth = $this->query($sql, [':idDeck' => $idDeck, ':idCreateur' => $idCreateur]);
        $res = $sth->fetch();
        return $res ? $res : false;
    }
    public function getCarteRandomFromDeck($idDeck)
    {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE id_deck = :idDeck ORDER BY RAND() LIMIT 1";
        $sth = $this->query($sql, [':idDeck' => $idDeck]);
        $res = $sth->fetch();
        return $res;
    }
    
    public function createCarteRng($idDeck, $idCreateur)
    {
        $res = $this->getCarteRandomFromDeck($idDeck);
        $idCarte = $res["id_carte"];

        $sql = "INSERT INTO `{$this->tableNameRng}` (`num_carte`, `id_deck`, `id_createur`) VALUES (:idCarte, :idDeck, :idCreateur)";
        $this->query($sql, [':idCarte' => $idCarte, ':idDeck' => $idDeck, ':idCreateur' => $idCreateur]);
        return $idCarte;
    }



    /**
     * Summary of findCarteByID
     * @param int $id
     * @return mixed
     */
    public function findCarteByID(
        int $id
    ) {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE id_carte = :id";
        $sth = $this->query($sql, [':id' => $id]);
        $res = $sth->fetch();
        return $res ? $res : false;
    }
    public function findAllCarteByCreateur(
        int $idCreateur
    ) {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE id_createur = :id_createur";
        $sth = $this->query($sql, [':id_createur' => $idCreateur]);
        $res = $sth->fetchAll();
        return $res ? $res : false;
    }

    /**
     * Summary of findCarteByDeck
     * @param int $deck
     * @param int $ordre
     * @return mixed
     */
    public function findCarteByDeck(
        int $deck,
        int $ordre
    ): ?array {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE id_deck = :idDeck ORDER BY ordre_soumission ASC";
        $sth = $this->query($sql, [':idDeck' => $deck, ':ordre' => $ordre]);
        $res = $sth->fetch();
        return $res ? $res : false;
    }
    public function getCarteMaxOrdre($idDeck)
    {
        $sql = "SELECT MAX(ordre_soumission) AS max_ordre FROM `{$this->tableName}` WHERE id_deck = :idDeck";
        $sth = $this->query($sql, [':idDeck' => $idDeck]);
        $res = $sth->fetch();

        return $res ? $res : null;
    }
}
