<?php

use App\Modele\Modele_Entreprise;
use App\Modele\Modele_Salarie;
use App\Modele\Modele_Utilisateur;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_Mail_Confirme;
use App\Vue\Vue_Mail_ReinitMdp;
use App\Vue\Vue_Menu_Administration;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;

use PHPMailer\PHPMailer\PHPMailer;

$Vue->setEntete(new Vue_Structure_Entete());

switch ($action) {
    case "reinitmdpconfirm":
        $Vue->addToCorps(new Vue_Mail_Confirme());
        break;

    case "reinitmdp":
        $Vue->addToCorps(new Vue_Mail_ReinitMdp());
        break;

    case "Se connecter":
        if (isset($_REQUEST["compte"]) and isset($_REQUEST["password"])) {
            $utilisateur = Modele_Utilisateur::Utilisateur_Select_ParLogin($_REQUEST["compte"]);

            if ($utilisateur != null) {
                if ($utilisateur["desactiver"] == 0) {
                    if ($_REQUEST["password"] == $utilisateur["motDePasse"]) {
                        $_SESSION["idUtilisateur"] = $utilisateur["idUtilisateur"];
                        $_SESSION["idCategorie_utilisateur"] = $utilisateur["idCategorie_utilisateur"];

                        // Check if the user has accepted the RGPD
                        if ($utilisateur["aAccepteRGPD"] == 1) {
                            switch ($utilisateur["idCategorie_utilisateur"]) {
                                case 1:
                                    $_SESSION["typeConnexionBack"] = "administrateurLogiciel";
                                    $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                                    break;
                                case 2:
                                    $_SESSION["typeConnexionBack"] = "gestionnaireCatalogue";
                                    $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                                    $Vue->addToCorps(new \App\Vue\Vue_AfficherMessage("Bienvenue " . $_REQUEST["compte"]));
                                    break;
                                case 3:
                                    $_SESSION["typeConnexionBack"] = "entrepriseCliente";
                                    $_SESSION["idEntreprise"] = Modele_Entreprise::Entreprise_Select_Par_IdUtilisateur($_SESSION["idUtilisateur"])["idEntreprise"];
                                    include "./Controleur/Controleur_Gerer_Entreprise.php";
                                    break;
                                case 4:
                                    $_SESSION["typeConnexionBack"] = "salarieEntrepriseCliente";
                                    $_SESSION["idSalarie"] = $utilisateur["idUtilisateur"];
                                    $_SESSION["idEntreprise"] = Modele_Salarie::Salarie_Select_byId($_SESSION["idUtilisateur"])["idEntreprise"];
                                    include "./Controleur/Controleur_Catalogue_client.php";
                                    break;
                                case 5:
                                    $_SESSION["typeConnexionBack"] = "commercialCafe";
                                    $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                                    break;
                            }
                        } else {
                            header('Location: /Controleur/Controleur_Accepter_RGPD.php');
                            exit;
                        }
                    } else {
                        $msgError = "Mot de passe erroné";
                        $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));
                    }
                } else {
                    $msgError = "Compte désactivé";
                    $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));
                }
            } else {
                $msgError = "Identification invalide";
                $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));
            }
        } else {
            $msgError = "Identification incomplete";
            $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));
        }
        break;

    default:
        $Vue->addToCorps(new Vue_Connexion_Formulaire_client());
        break;
}

$Vue->setBasDePage(new Vue_Structure_BasDePage());