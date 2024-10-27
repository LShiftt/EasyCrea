<?php

declare(strict_types=1); // strict mode

namespace App\Controller;

use App\Helper\HTTP;
use App\Model\Deck;
use App\Model\Carte;
use App\Controller\CheckAuth;


class DeckController extends Controller
{
    /**
     * Affiche les decks et les boutons appropriées
     * @param mixed $success
     * @return void
     */
    public function index($success = false)
    {
        CheckAuth::checkAuthentication();
        $res = Deck::getInstance()->findAll();
        if ($_SESSION["rank"] === "Admin") {
            $admin = $_SESSION["rank"];
            $this->display('deck/index.html.twig', compact("res", "admin"));
        } else {
            // Ajoutez un tableau pour stocker les decks avec isFull
            $decksWithIsFull = [];
            if ($_SESSION["rank"] === "Créateur") {
                $resCartes = Carte::getInstance()->findAllCarteByCreateur($_SESSION["id"]);
                $participationDeck = [];

                foreach ($res as $resDeck) {
                    $isFull = Deck::getInstance()->isFull($resDeck["id_deck"]);
                    $resDeck["isFull"] = $isFull;

                    $decksWithIsFull[] = $resDeck;
                }

                if ($resCartes != false) {
                    foreach ($resCartes as $resCarte) {
                        $participationDeck[] = strval($resCarte["id_deck"]);
                    }
                }
            }
            $this->display('deck/index.html.twig', compact("decksWithIsFull", "resCartes", "success", "participationDeck"));
        }
    }

    /**
     * Insertion d'un deck
     * @return void
     */
    public function createDeck()
    {
        CheckAuth::checkAuthentication();
        if ($this->isGetMethod()) {
            $this->display('deck/create.html.twig');
        } else {
            $dateDeb = date("Y-m-d");
            $nbJaimes = 0;
            $res = Deck::getInstance()->createDeck(
                trim($_POST['titre']),
                $dateDeb,
                trim($_POST['dateFin']),
                trim($_POST['nbCarte']),
                $nbJaimes,
                $_SESSION["id"]
            );

            $idDeck = Deck::getInstance()->findDeckID();
            $dateAuj = $dateDeb;

            $val1 = trim($_POST['population1']) . "/" . trim($_POST['finance1']);
            $val2 = trim($_POST['population2']) . "/" . trim($_POST['finance2']);

            Carte::getInstance()->createCarteAdmin(
                trim($_POST['texte']),
                $val1,
                $val2,
                $dateAuj,
                1,
                $_SESSION["id"],
                $idDeck["id_deck"]
            );

            if ($res === true) {
                $this->index();
            } elseif ($res === false) {
                $error = "Insertion raté";
                $this->display('deck/create.html.twig', compact("error"));
            }

        }
    }
}
