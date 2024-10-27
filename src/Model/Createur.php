<?php

declare(strict_types=1);

namespace App\Model;

class Createur extends Model
{
    use TraitInstance;

    protected $tableName = APP_TABLE_PREFIX . 'createur';
    protected $tableNameAdmin = APP_TABLE_PREFIX . 'administrateur';

    public function register(
        string $nom,
        string $mail,
        string $mdp,
        string $genre,
        string $ddn
    ) {
        $sql = "INSERT INTO `{$this->tableName}` (nom_createur, ad_mail_createur, mdp_createur, genre, ddn) VALUES (:nom, :mail, :mdp, :genre, :ddn)";
        $sth = $this->query($sql, [
            ':nom' => $nom,
            ':mail' => $mail,
            ':mdp' => $mdp,
            ':genre' => $genre,
            ':ddn' => $ddn
        ]);
        return $sth ? true : false;
    }
    public function findCreateurByID(
        int $id
    ): ?array {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE id_createur = :id";
        $sth = $this->query($sql, [':id' => $id]);
        $res = $sth->fetch();
        return $res ? $res : false;
    }
    public function findCreateurByMail(
        string $mail
    ): ?array {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE ad_mail_createur = :mail";
        $sth = $this->query($sql, [':mail' => $mail]);
        $res = $sth->fetch();
        return $res ? $res : false;
    }
    public function emailExist(
        string $mail
    ): bool {
        $sql = "SELECT COUNT(ad_mail_createur) FROM `{$this->tableName}` WHERE ad_mail_createur = :mail";
        $sth = $this->query($sql, [':mail' => $mail]);
        $count = $sth->fetchColumn();

        if ($count > 0) {
            return true;
        } else {
            $sql2 = "SELECT COUNT(ad_mail_admin) FROM `{$this->tableNameAdmin}` WHERE ad_mail_admin = :mail";
            $sth2 = $this->query($sql2, [':mail' => $mail]);
            $countAdmin = $sth2->fetchColumn();
            return $countAdmin > 0;
        }
    }
}
