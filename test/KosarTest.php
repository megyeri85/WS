<?php

use PHPUnit\Framework\TestCase;

require_once '../content/Kosar.php';

class KosarTest extends TestCase
{
    public function setUp(): void
    {
        $_SESSION = [];
        $this->kosar = new Kosar();
    }

    public function testKosarConstructor()
    {

        $this->assertInstanceOf('Kosar', $this->kosar);
    }

    public function testAdd_aru_egy_termekkel()
    {

        $this->kosar->add_aru(1);
        $this->assertArrayHasKey(1, $_SESSION);
    }

    public function testAdd_aru_kulonbozo_termekkel()
    {
        $this->kosar->add_aru(1);
        $this->kosar->add_aru(2);
        $this->assertArrayHasKey(1, $_SESSION);
        $this->assertArrayHasKey(2, $_SESSION);
        $this->kosar->add_aru(2);
        $this->assertEquals(2, $_SESSION[2]);
    }

    public function testKosar_szamit_egy_fajta_csoport_kedvezmenyes()
    {
        $this->kosar->add_aru("#1003");
        $this->kosar->add_aru("#1003");
        $this->kosar->add_aru("#1003");

        $this->assertEquals(['osszeg' => 11100, 'kedvezmenyek' => 3700, 'kedvezmenyes_osszeg' => 7400], $this->kosar->kosar_szamit());


    }

    public function testKosar_szamit_tobb_fajta_csoport_kedvezmenyes()
    {
        $this->kosar->add_aru("#1003");
        $this->kosar->add_aru("#1003");
        $this->kosar->add_aru("#1003");
        $this->assertEquals(['osszeg' => 11100, 'kedvezmenyek' => 3700, 'kedvezmenyes_osszeg' => 7400], $this->kosar->kosar_szamit());
        $this->kosar->add_aru("#1001");
        $this->assertEquals(['osszeg' => 14700, 'kedvezmenyek' => 3600, 'kedvezmenyes_osszeg' => 11100], $this->kosar->kosar_szamit());


    }

    public function testKosar_szamit_tobb_fajta_csoport_es_forint_kedvezmenyes()
    {
        $this->kosar->add_aru("#1005");
        $this->kosar->add_aru("#1005");
        $this->assertEquals(['osszeg' => 9000, 'kedvezmenyek' => 1000, 'kedvezmenyes_osszeg' => 8000], $this->kosar->kosar_szamit());
        $this->kosar->add_aru("#1005");
        $this->assertEquals(['osszeg' => 13500, 'kedvezmenyek' => 6000, 'kedvezmenyes_osszeg' => 7500], $this->kosar->kosar_szamit());
        $this->kosar->add_aru("#1001");
        $this->assertEquals(['osszeg' => 17100, 'kedvezmenyek' => 5100, 'kedvezmenyes_osszeg' => 12000], $this->kosar->kosar_szamit());
    }


    public function testKosar_szamit_egy_fajta_nem_kedvezmenyes()
    {
        $this->kosar->add_aru("#1007");
        $this->kosar->add_aru("#1007");
        $this->kosar->add_aru("#1007");

        $this->assertEquals(['osszeg' => 10800, 'kedvezmenyek' => 0, 'kedvezmenyes_osszeg' => 10800], $this->kosar->kosar_szamit());


    }

    public function testKosar_szamit_egytermek()
    {

        $this->kosar->add_aru("#1003");
        $this->assertEquals(['osszeg' => 3700, 'kedvezmenyek' => 0, 'kedvezmenyes_osszeg' => 3700], $this->kosar->kosar_szamit());
    }

    public function testKosar_szamit_egytermek_szazalekos()
    {

        $this->kosar->add_aru("#1006");
        $this->assertEquals(['osszeg' => 3600, 'kedvezmenyek' => 360, 'kedvezmenyes_osszeg' => 3240], $this->kosar->kosar_szamit());
    }

    public function testKosar_szamit_egytermek_forintos()
    {

        $this->kosar->add_aru("#1002");
        $this->assertEquals(['osszeg' => 2900, 'kedvezmenyek' => 500, 'kedvezmenyes_osszeg' => 2400], $this->kosar->kosar_szamit());
    }


    public function testOssz_menny_kedv()
    {
        $this->assertEquals([['kedv_id' => '103', 'aru_id' => null, 'kedv_tip_id' => '3', 'kedvezmeny_menny' => '1', 'kiado_id' => '1']],
            $this->kosar->ossz_menny_kedv());
    }


    public function testKosar_urites()
    {
        $this->kosar->add_aru(1);
        $this->kosar->add_aru(2);
        $this->kosar->add_aru(1);
        $this->kosar->add_aru(2);
        $this->assertEquals(2, count($_SESSION));
        $this->kosar->kosar_urites();
        $this->assertEquals(0, count($_SESSION));

    }
}
