<?php

declare(strict_types=1); // strict mode

namespace App\Controller;
use App\Helper\HTTP;
class CheckAuth
{
    /**
     * Vérifie si l'utilisateur est connecté, sinon redirige vers la page de connexion.
     */
    public static function checkAuthentication(): void
    {
        if (!isset($_SESSION["id"])) {
            HTTP::redirect('/home/login');
            exit();
        }
    }
}
