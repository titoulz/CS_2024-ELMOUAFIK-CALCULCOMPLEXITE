<?php
namespace App\Vue;

class Vue_Accepter_RGPD
{
    public function afficherFormulaire()
    {
        echo '<form method="post" action="Controleur_AccepterRGPD.php?action=AccepterRGPD">';
        echo '<label for="rgpd">Accepter le RGPD</label>';
        echo '<input type="checkbox" id="rgpd" name="rgpd" value="1" required>';
        echo '<input type="submit" value="Enregistrer">';
        echo '</form>';
        echo '<form method="post" action="Controleur_AccepterRGPD.php?action=RefuserRGPD">';
        echo '<input type="submit" value="Refuser">';
        echo '</form>';
    }
}