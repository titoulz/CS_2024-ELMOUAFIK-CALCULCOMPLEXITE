<?php


namespace App\Vue;

class Vue_Accepter_RGPD
{
    public function afficherFormulaire()
    {
        echo '<form method="post" action="enregistrer_utilisateur.php">';
        echo '<label for="rgpd">Accepter le RGPD</label>';
        echo '<input type="checkbox" id="rgpd" name="rgpd" value="1">';
        echo '<input type="submit" value="Enregistrer">';
        echo '</form>';
    }
}