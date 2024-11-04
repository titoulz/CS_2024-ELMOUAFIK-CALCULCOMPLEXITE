<?php

use PHPUnit\Framework\TestCase;
use App\Fonctions;

class FonctionsTest extends TestCase
{
    public function testCalculComplexiteMdp()
    {
        $this->assertEquals(5, Fonctions\CalculComplexiteMdp('abc'));
        $this->assertEquals(6, Fonctions\CalculComplexiteMdp('aBc'));
        $this->assertEquals(7, Fonctions\CalculComplexiteMdp('aB1'));
        $this->assertEquals(8, Fonctions\CalculComplexiteMdp('aB1!'));
        $this->assertEquals(4, Fonctions\CalculComplexiteMdp('1234'));
    }
}