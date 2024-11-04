<?php
// src/Controleur/Controleur_AccepterRGPD.php
use App\Vue\Vue_Accepter_RGPD;
use App\Modele\Modele_Utilisateur;

switch ($_REQUEST['action'] ?? 'AfficherRGPD') {
    case 'AccepterRGPD':
        $utilisateur = Modele_Utilisateur::Utilisateur_Select_ParId($_SESSION['idUtilisateur']);
        $utilisateur->setAAccepteRGPD(1);
        $utilisateur->setDateAcceptionRGPD(date('Y-m-d H:i:s'));
        $utilisateur->setIP($_SERVER['REMOTE_ADDR']);
        Modele_Utilisateur::Utilisateur_Modifier($utilisateur);
        // Envoyer une notification à l'utilisateur
        mail($utilisateur->getEmail(), "Consentement RGPD", "Vous avez accepté le RGPD.");
        header('Location: index.php');
        break;

    case 'RefuserRGPD':
        session_destroy();
        header('Location: login.php');
        break;

    default:
        $vue = new Vue_Accepter_RGPD();
        $vue->afficherFormulaire();
        break;
}