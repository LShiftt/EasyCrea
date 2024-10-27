<?php

declare(strict_types=1); // strict mode

namespace App\Controller;

use App\Helper\HTTP;
use App\Model\Home;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil
     * @return void
     */
    public function index()
    {
        $this->display('home/index.html.twig');
    }

    /**
     * Connexion
     * @return void
     */
    public function login()
    {
        if ($this->isGetMethod()) {
            $_SESSION = array();
            $this->display('home/login.html.twig');
        } else {
            // POST
            // admin
            $res = Home::getInstance()->findAdmin(trim($_POST['email']));
            if ($res && password_verify(trim($_POST['password']), $res['mdp_admin'])) {
                $infos = $res;
                $infos['rank'] = "Admin";
                $_SESSION["id"] = $infos["id_administrateur"];
                $_SESSION["rank"] = $infos["rank"];
                $this->display('home/index.html.twig', compact('infos'));
            } else {
                // createur
                $res = Home::getInstance()->findCreateur(trim($_POST['email']));
                if ($res && password_verify(trim($_POST['password']), $res['mdp_createur'])) {
                    $infos = $res;
                    $infos['rank'] = "Créateur";
                    $_SESSION["id"] = $infos["id_createur"];
                    $_SESSION["rank"] = $infos["rank"];
                    $_SESSION["nom"] = $infos["nom_createur"];
                    $this->display('home/index.html.twig', compact('infos'));
                } else {
                    // Si l'utilisateur n'est ni admin ni créateur
                    $res = false;
                    $this->display('home/login.html.twig', compact('res'));
                }
            }
        }
    }
    /**
     * Deconnexion
     * @return void
     */
    public function logout()
    {
        $_SESSION = array();
        session_destroy();
        $this->display('home/index.html.twig');
    }

}
