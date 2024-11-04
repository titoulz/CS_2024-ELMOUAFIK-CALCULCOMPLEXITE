<?php
namespace App\Fonctions;
    function Redirect_Self_URL():void{
        unset($_REQUEST);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }

function GenereMDP($nbChar) :string{

    return "secret";
}

    function CalculComplexiteMdp($mdp) :int{
        $length = strlen($mdp);
        $complexity = 0;

        if (preg_match('/[a-z]/', $mdp)) {
            $complexity += 1;
        }
        if (preg_match('/[A-Z]/', $mdp)) {
            $complexity += 1;
        }
        if (preg_match('/[0-9]/', $mdp)) {
            $complexity += 1;
        }
        if (preg_match('/[\W]/', $mdp)) {
            $complexity += 1;
        }

        return $length + $complexity;
    }