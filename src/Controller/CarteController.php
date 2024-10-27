<?php

declare(strict_types=1); // strict mode

namespace App\Controller;

use App\Helper\HTTP;
use App\Controller\DeckController;
use App\Model\Carte;
use App\Model\Deck;


class CarteController extends Controller
{
    /**
     * Insertion d'une carte
     * @param string $idDeck
     * @return void
     */
    public function add(string $idDeck = null)
    {
        CheckAuth::checkAuthentication();
        if ($this->isGetMethod()) {
            $idDeck = (int) $idDeck;
            $res = Deck::getInstance()->findDeckByID($idDeck);

            $resRng = Carte::getInstance()->getCarteRng($idDeck, $_SESSION['id']);
            if ($resRng === false) {
                $resRng = Carte::getInstance()->createCarteRng($idDeck, $_SESSION['id']);
            }
            if (is_array($resRng)) {
                $resRng = Carte::getInstance()->findCarteByID($resRng["num_carte"]);
            }else {
                $resRng = Carte::getInstance()->findCarteByID($resRng);
            }
            list($resRng['valeurs_choix1_pop'], $resRng['valeurs_choix1_fin']) = explode('/', $resRng['valeurs_choix1']);
            list($resRng['valeurs_choix2_pop'], $resRng['valeurs_choix2_fin']) = explode('/', $resRng['valeurs_choix2']);
            $this->display('carte/add.html.twig', compact('res', 'resRng'));
        } else {
            // POST
            $idDeck = (int) $_POST['idDeck'];
            $res = Deck::getInstance()->findDeckByID($idDeck);

            $ordre = Carte::getInstance()->getCarteMaxOrdre($idDeck);
            $ordre['max_ordre'] = $ordre['max_ordre'] + 1;

            $val1 = trim($_POST['population1']) . "/" . trim($_POST['finance1']);
            $val2 = trim($_POST['population2']) . "/" . trim($_POST['finance2']);
            $dateAuj = date("Y-m-d");
            Carte::getInstance()->createCarte(
                trim($_POST['texte']),
                $val1,
                $val2,
                $dateAuj,
                $ordre['max_ordre'],
                $_SESSION["id"],
                $idDeck
            );
            $success = "Merci de votre participation";
            $deckController = new DeckController();
            $deckController->index($success);
        }
    }
    /**
     * Affiche la carte et l'exemple
     * @param string $idDeck
     * @return void
     */
    function index(string $idDeck = null)
    {
        CheckAuth::checkAuthentication();
        $idDeck = (int) $idDeck;
        $deck = Deck::getInstance()->findDeckByID($idDeck);

        $resCartes = Carte::getInstance()->findAllCarteByCreateur($_SESSION["id"]);
        foreach ($resCartes as $resCarte) {
            if ($resCarte['id_deck']) {
                list($resCarte['valeurs_choix1_pop'], $resCarte['valeurs_choix1_fin']) = explode('/', $resCarte['valeurs_choix1']);
                list($resCarte['valeurs_choix2_pop'], $resCarte['valeurs_choix2_fin']) = explode('/', $resCarte['valeurs_choix2']);
                $res = $resCarte;
            }
        }
        $resRng = Carte::getInstance()->getCarteRng($idDeck, $_SESSION['id']);

        $resRng = Carte::getInstance()->findCarteByID($resRng['num_carte']);
        list($resRng['valeurs_choix1_pop'], $resRng['valeurs_choix1_fin']) = explode('/', $resRng['valeurs_choix1']);
        list($resRng['valeurs_choix2_pop'], $resRng['valeurs_choix2_fin']) = explode('/', $resRng['valeurs_choix2']);

        $this->display('carte/index.html.twig', compact("deck", "res", "resRng"));
    }
}
