<?php

declare(strict_types=1);

namespace App\Model;
class Deck extends Model
{
    use TraitInstance;

    protected $tableName = APP_TABLE_PREFIX . 'deck';
    protected $tableCarte = APP_TABLE_PREFIX . 'carte';

    public function createDeck(
        string $titre, //aff
        string $dateDeb,
        string $dateFin, //aff
        string $nbCartes, //aff
        int $nbJaimes,
        int $idAdmin
    ) {
        $sql = "INSERT INTO `{$this->tableName}` (titre_deck, date_debut_deck, date_fin_deck, nb_cartes, nb_jaime, id_administrateur) 
        VALUES (:titre, :dateDeb, :dateFin, :nbCartes, :nbJaimes, :idAdmin)";

        $sth = $this->query($sql, [
            ':titre' => $titre,
            ':dateDeb' => $dateDeb,
            ':dateFin' => $dateFin,
            ':nbCartes' => $nbCartes,
            ':nbJaimes' => $nbJaimes,
            ':idAdmin' => $idAdmin
        ]);
        return $sth ? true : false;
    }

    /**
     * Effacer un deck
     * @param string $id
     * @return mixed
     */
    public function deleteDeck(string $id)
    {
        $sql = "DELETE FROM `{$this->tableName}` WHERE id_deck = :id";
        $sth = $this->query($sql, [':id' => $id]);
        $res = $sth->fetch();
        return $res;
    }

    public function findDeckByID(
        int $id
    ) {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE id_deck = :id";
        $sth = $this->query($sql, [':id' => $id]);
        $res = $sth->fetch();
        return $res ? $res : false;
    }
    public function findDeckID()
    {
        $sql = "SELECT id_deck FROM `{$this->tableName}` ORDER BY id_deck DESC LIMIT 1";
        $sth = $this->query($sql);
        $res = $sth->fetch();
        return $res ? $res : false;
    }
    public function isFull(int $idDeck): bool
    {
        $sql = "SELECT nb_cartes AS nb_max_cartes FROM `{$this->tableName}` WHERE id_deck = :idDeck";
        $sth = $this->query($sql, [':idDeck' => $idDeck]);
        $res = $sth->fetch();

        $nbMaxCartes = (int) $res['nb_max_cartes'];

        $sql = "SELECT COUNT(*) AS nb_actuel_cartes FROM `{$this->tableCarte}` WHERE id_deck = :idDeck";
        $sth = $this->query($sql, [':idDeck' => $idDeck]);
        $res2 = $sth->fetch();

        $nbActuelCartes = (int) $res2['nb_actuel_cartes'];

        if ($nbMaxCartes <= $nbActuelCartes) {
            return true;
        }
        return false;
    }
}
