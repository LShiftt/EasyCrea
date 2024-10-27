<?php

declare(strict_types=1); // strict mode

namespace App\Controller;

use App\Helper\HTTP;
use App\Model\Createur;

class CreateurController extends Controller
{



    /**
     * Insertion d'un nouveau créateur
     * @return void
     */
    public function register()
    {
        if ($this->isGetMethod()) {
            $_SESSION = array();
            $this->display('createur/register.html.twig');
        } else {
            // POST
            $mail = trim($_POST['mail']);

            $mdpHashed = password_hash(trim($_POST['mdp']), PASSWORD_BCRYPT);
            $resExist = Createur::getInstance()->emailExist($mail);
            if ($resExist === true) {
                $this->display('createur/register.html.twig', compact('res'));
            } else {
                $res = Createur::getInstance()->register(
                    trim($_POST['nom']),
                    $mail,
                    $mdpHashed,
                    trim($_POST['genre']),
                    trim($_POST['date'])
                );
                $res = Createur::getInstance()->findCreateurByMail($mail);
                $res["rank"] = "Créateur";
                $_SESSION["id"] = $res["id_createur"];
                $_SESSION["rank"] = $res["rank"];
                $_SESSION["nom"] = $res["nom_createur"];
                $message = "Merci d'avoir rejoint l'équipe de création " . $_SESSION["nom"] . "😁👍.";
                $this->display('home/index.html.twig', compact('message'));
            }
        }
    }
}
