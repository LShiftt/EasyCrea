<?php

declare(strict_types=1);
/*
-------------------------------------------------------------------------------
les routes
-------------------------------------------------------------------------------
 */

return [

    // accueil
    ['GET', '/', 'home@index'],
    ['GET', '/index', 'home@index'],
    ['GET', '/home', 'home@index'],
    ['GET', '/accueil', 'home@index'],


    // afficher le formulaire de connexion
    ['GET', '/home/login', 'home@login'],

    // enregistrer les données soumises de connexion
    ['POST', '/home/login', 'home@login'], // fail
    ['POST', '/home', 'home@login'], // succes

    // deconnexion
    ['GET', '/home/logout', 'home@logout'],

    // afficher le formulaire de connexion
    ['GET', '/createur/register', 'createur@register'],

    // enregistrer les données soumises de connexion
    ['POST', '/createur/register', 'createur@register'], // fail

    // afficher les decks
    ['GET', '/deck', 'deck@index'],

    // afficher le formulaire de création de deck
    ['GET', '/deck/create', 'deck@createDeck'],
    // enregistrer les données de création de deck
    ['POST', '/deck/create', 'deck@createDeck'],

    // afficher le formulaire de création de carte
    ['GET', '/deck/add/{deck_id:\d+}', 'carte@add'],
    // enregistrer les données de création de carte
    ['POST', '/deck/add', 'carte@add'],

    // afficher la carte et la carte 
    ['GET', '/carte/index/{deck_id:\d+}', 'carte@index'],



    // // effacer un etudiant
    // ['GET', '/etudiants/effacer/{id:\d+}', 'etudiant@delete'],

];
