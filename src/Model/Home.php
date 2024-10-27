<?php

declare(strict_types=1);

namespace App\Model;

class Home extends Model
{
    use TraitInstance;

    protected $tableNameCreateur = APP_TABLE_PREFIX . 'createur';
    protected $tableNameAdmin = APP_TABLE_PREFIX . 'administrateur';


    public function findAdmin(string $mail)
    {
        $sql = "SELECT id_administrateur, mdp_admin FROM `{$this->tableNameAdmin}` WHERE ad_mail_admin = :mail";
        $sth = $this->query($sql, [':mail' => $mail]);
        return $sth->fetch();
    }
    
    public function findCreateur(string $mail)
    {
        $sql = "SELECT id_createur, nom_createur, mdp_createur FROM `{$this->tableNameCreateur}` WHERE ad_mail_createur = :mail";
        $sth = $this->query($sql, [':mail' => $mail]);
        return $sth->fetch();
    }    
}
