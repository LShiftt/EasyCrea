<?php 
declare(strict_types=1);

namespace App\Model;
class Etudiant extends Model 
{ 
    use TraitInstance;
    protected $tableName = APP_TABLE_PREFIX . 'etudiant'; 
    protected $tableParcours = APP_TABLE_PREFIX . 'parcours'; 
  
    public function findAllDetailled()
    { 
        $sql = "SELECT e.*,p.nom as parcours 
                FROM {$this->tableName} e, {$this->tableParcours} p 
                WHERE e.parcours_id = p.id  
                ORDER BY e.nom,e.prenom ";
        $sth = self::$dbh->prepare($sql); 
        $sth->execute(); 
 
        return $sth->fetchAll(); 
    } 
} 