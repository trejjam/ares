<?php declare(strict_types=1);

namespace Trejjam\Ares\Tests;

use SimpleXMLElement;
use Tester;
use Tester\Assert;
use Trejjam\Ares;

require __DIR__ . '/../bootstrap.php';

class MapperTest extends Tester\TestCase
{
    private Ares\Mapper $mapper;

    protected function setUp() : void
    {
        $this->mapper = new Ares\Mapper;
    }

    public function testMap() : void
    {
        $xml = simplexml_load_string(
            '<?xml version="1.0" encoding="UTF-8"?>
<are:Ares_odpovedi xmlns:are="http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/ares/ares_answer_basic/v_1.0.3" xmlns:D="http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/ares/ares_datatypes/v_1.0.3" xmlns:U="http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/uvis_datatypes/v_1.0.3" odpoved_datum_cas="2023-04-05T15:47:07" odpoved_pocet="1" odpoved_typ="Basic" vystup_format="XML" xslt="klient" validation_XSLT="http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/ares/ares_odpovedi.xsl" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/ares/ares_answer_basic/v_1.0.3 http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/ares/ares_answer_basic/v_1.0.3/ares_answer_basic_v_1.0.3.xsd" Id="ares">
<are:Odpoved>
<D:PID>0</D:PID>
<D:VH>
<D:K>1</D:K>
</D:VH>
<D:PZA>1</D:PZA>
<D:UVOD>
<D:ND>Výpis z dat Registru ARES - aktuální stav ke dni 2023-04-05</D:ND>
<D:ADB>2023-04-05</D:ADB>
<D:DVY>2023-04-05</D:DVY>
<D:CAS>15:47:07</D:CAS>
<D:Typ_odkazu>0</D:Typ_odkazu>
</D:UVOD>
<D:VBAS>
<D:ICO zdroj="OR">27074358</D:ICO>
<D:DIC zdroj="DPH">CZ27074358</D:DIC>
<D:OF zdroj="OR">Asseco Central Europe, a.s.</D:OF>
<D:DV>2003-08-06</D:DV>
<D:PF zdroj="OR">
<D:KPF>121</D:KPF>
<D:NPF>Akciová společnost</D:NPF>
</D:PF>
<D:AD zdroj="ARES">
<D:UC>Budějovická 778</D:UC>
<D:PB>14000 Praha</D:PB>
</D:AD>
<D:AA zdroj="ARES">
<D:IDA>213240246</D:IDA>
<D:KS>203</D:KS>
<D:NS>Česká republika</D:NS>
<D:N>Praha</D:N>
<D:NCO>Michle</D:NCO>
<D:NMC>Praha 4</D:NMC>
<D:NU>Budějovická</D:NU>
<D:CD>778</D:CD>
<D:TCD>1</D:TCD>
<D:CO>3a</D:CO>
<D:PSC>14000</D:PSC>
<D:AU>
<U:KOL>19</U:KOL>
<U:KK>19</U:KK>
<U:KOK>3100</U:KOK>
<U:KO>554782</U:KO>
<U:KPO>43</U:KPO>
<U:KN>43</U:KN>
<U:KCO>490130</U:KCO>
<U:KMC>500119</U:KMC>
<U:PSC>14000</U:PSC>
<U:KUL>444375</U:KUL>
<U:CD>778</U:CD>
<U:TCD>1</U:TCD>
<U:CO>3</U:CO>
<U:PCO>a</U:PCO>
<U:KA>41405609</U:KA>
<U:KOB>21770794</U:KOB>
</D:AU>
</D:AA>
<D:PSU>NAAANANNNNANNNNNNNNNPNNNANNNNN</D:PSU>
<D:ROR>
<D:SZ>
<D:SD>
<D:K>1</D:K>
<D:T>Městský soud v Praze</D:T>
</D:SD>
<D:OV>B 8525</D:OV>
</D:SZ>
<D:SOR>
<D:SSU>Aktivní</D:SSU>
<D:KKZ>
<D:K>0</D:K>
</D:KKZ>
<D:VY>
<D:K>0</D:K>
</D:VY>
<D:ZAM>
<D:K>0</D:K>
</D:ZAM>
<D:LI>
<D:K>0</D:K>
</D:LI>
</D:SOR>
</D:ROR>
<D:RRZ>
<D:ZU>
<D:KZU>310004</D:KZU>
<D:NZU>Úřad městské části Praha 4</D:NZU>
</D:ZU>
<D:FU>
<D:KFU>4</D:KFU>
<D:NFU>Praha 4</D:NFU>
</D:FU>
</D:RRZ>
<D:KPP zdroj="RES">250 - 499 zaměstnanců</D:KPP>
<D:Nace>
<D:NACE zdroj="RES">181</D:NACE>
<D:NACE zdroj="RES">261</D:NACE>
<D:NACE zdroj="RES">26300</D:NACE>
<D:NACE zdroj="RES">43210</D:NACE>
<D:NACE zdroj="RES">461</D:NACE>
<D:NACE zdroj="RES">46900</D:NACE>
<D:NACE zdroj="RES">47</D:NACE>
<D:NACE zdroj="RES">52290</D:NACE>
<D:NACE zdroj="RES">5590</D:NACE>
<D:NACE zdroj="RES">61</D:NACE>
<D:NACE zdroj="RES">620</D:NACE>
<D:NACE zdroj="RES">63</D:NACE>
<D:NACE zdroj="RES">6820</D:NACE>
<D:NACE zdroj="RES">69200</D:NACE>
<D:NACE zdroj="RES">711</D:NACE>
<D:NACE zdroj="RES">7120</D:NACE>
<D:NACE zdroj="RES">73120</D:NACE>
<D:NACE zdroj="RES">73200</D:NACE>
<D:NACE zdroj="RES">74</D:NACE>
<D:NACE zdroj="RES">74300</D:NACE>
<D:NACE zdroj="RES">80</D:NACE>
<D:NACE zdroj="RES">80200</D:NACE>
<D:NACE zdroj="RES">8559</D:NACE>
</D:Nace>
<D:PPI>
<D:PP zdroj="OR">
<D:T>
Činnost účetních poradců, vedení účetnictví, vedení daňové evidence
</D:T>
<D:T>
pronájem nemovitostí, bytů a nebytových prostor s poskytováním jen základních služeb zajišťujících řádný provoz nemovitostí, bytů a nebytových prostor
</D:T>
<D:T>
Montáž, opravy, revize a zkoušky elektrických zařízení
</D:T>
<D:T>
Výroba, obchod a služby neuvedené v přílohách 1 až 3 živnostenského zákona
</D:T>
<D:T>
Výroba, instalace, opravy elektrických strojů a přístrojů, elektronických a telekomunikačních zařízení
</D:T>
<D:T>
poskytování technických služeb k ochraně majetku a osob
</D:T>
</D:PP>
<D:PP zdroj="RZP">
<D:T>Výroba, instalace, opravy elektrických strojů a přístrojů, elektronických a telekomunikačních zařízení</D:T>
<D:T>Poskytování technických služeb k ochraně majetku a osob</D:T>
<D:T>Výroba, obchod a služby neuvedené v přílohách 1 až 3 živnostenského zákona</D:T>
<D:T>Činnost účetních poradců, vedení účetnictví, vedení daňové evidence</D:T>
<D:T>Montáž, opravy, revize a zkoušky elektrických zařízení</D:T>
</D:PP>
</D:PPI>
<D:Obory_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01014</D:K>
<D:T>Vydavatelské činnosti, polygrafická výroba, knihařské a kopírovací práce</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01047</D:K>
<D:T>Zprostředkování obchodu a služeb</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01048</D:K>
<D:T>Velkoobchod a maloobchod</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01052</D:K>
<D:T>Skladování, balení zboží, manipulace s nákladem a technické činnosti v dopravě</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01053</D:K>
<D:T>Zasilatelství a zastupování v celním řízení</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01055</D:K>
<D:T>Ubytovací služby</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01056</D:K>
<D:T>Poskytování software, poradenství v oblasti informačních technologií, zpracování dat, hostingové a související činnosti a webové portály</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01060</D:K>
<D:T>Poradenská a konzultační činnost, zpracování odborných studií a posudků</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01062</D:K>
<D:T>Příprava a vypracování technických návrhů, grafické a kresličské práce</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01063</D:K>
<D:T>Projektování elektrických zařízení</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01064</D:K>
<D:T>Výzkum a vývoj v oblasti přírodních a technických věd nebo společenských věd</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01065</D:K>
<D:T>Testování, měření, analýzy a kontroly</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01066</D:K>
<D:T>Reklamní činnost, marketing, mediální zastoupení</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01070</D:K>
<D:T>Služby v oblasti administrativní správy a služby organizačně hospodářské povahy</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01072</D:K>
<D:T>Mimoškolní výchova a vzdělávání, pořádání kurzů, školení, včetně lektorské činnosti</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01080</D:K>
<D:T>Výroba, obchod a služby jinde nezařazené</D:T>
</D:Obor_cinnosti>
</D:Obory_cinnosti>
</D:VBAS>
</are:Odpoved>
</are:Ares_odpovedi>'
        );

        /** @var SimpleXMLElement $xml */
        Assert::type(SimpleXMLElement::class, $xml);

        $aresEntity = $this->mapper->map($xml, '27074358');

        Assert::notNull($aresEntity);
        Assert::type(Ares\Entity\Ares::class, $aresEntity);

        Assert::equal('778', $aresEntity->address->houseNumber);
        Assert::equal('3a', $aresEntity->address->referenceNumber);
    }

    public function testMapWithCaField() : void
    {
        $xml = simplexml_load_string(
            '<?xml version="1.0" encoding="UTF-8"?>
<are:Ares_odpovedi xmlns:are="http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/ares/ares_answer_basic/v_1.0.3" xmlns:D="http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/ares/ares_datatypes/v_1.0.3" xmlns:U="http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/uvis_datatypes/v_1.0.3" odpoved_datum_cas="2023-04-05T15:47:07" odpoved_pocet="1" odpoved_typ="Basic" vystup_format="XML" xslt="klient" validation_XSLT="http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/ares/ares_odpovedi.xsl" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/ares/ares_answer_basic/v_1.0.3 http://wwwinfo.mfcr.cz/ares/xml_doc/schemas/ares/ares_answer_basic/v_1.0.3/ares_answer_basic_v_1.0.3.xsd" Id="ares">
<are:Odpoved>
<D:PID>0</D:PID>
<D:VH>
<D:K>1</D:K>
</D:VH>
<D:PZA>1</D:PZA>
<D:UVOD>
<D:ND>Výpis z dat Registru ARES - aktuální stav ke dni 2023-04-05</D:ND>
<D:ADB>2023-04-05</D:ADB>
<D:DVY>2023-04-05</D:DVY>
<D:CAS>15:47:07</D:CAS>
<D:Typ_odkazu>0</D:Typ_odkazu>
</D:UVOD>
<D:VBAS>
<D:ICO zdroj="OR">27074358</D:ICO>
<D:DIC zdroj="DPH">CZ27074358</D:DIC>
<D:OF zdroj="OR">Asseco Central Europe, a.s.</D:OF>
<D:DV>2003-08-06</D:DV>
<D:PF zdroj="OR">
<D:KPF>121</D:KPF>
<D:NPF>Akciová společnost</D:NPF>
</D:PF>
<D:AD zdroj="ARES">
<D:UC>Budějovická 778</D:UC>
<D:PB>14000 Praha</D:PB>
</D:AD>
<D:AA zdroj="ARES">
<D:IDA>210870551</D:IDA>
<D:KS>203</D:KS>
<D:NS>Česká republika</D:NS>
<D:N>Praha 6</D:N>
<D:NCO>Břevnov</D:NCO>
<D:NU>U třetí baterie</D:NU>
<D:CA>1056/5</D:CA>
<D:PSC>16200</D:PSC>
<D:AU> </D:AU>
</D:AA>
<D:PSU>NAAANANNNNANNNNNNNNNPNNNANNNNN</D:PSU>
<D:ROR>
<D:SZ>
<D:SD>
<D:K>1</D:K>
<D:T>Městský soud v Praze</D:T>
</D:SD>
<D:OV>B 8525</D:OV>
</D:SZ>
<D:SOR>
<D:SSU>Aktivní</D:SSU>
<D:KKZ>
<D:K>0</D:K>
</D:KKZ>
<D:VY>
<D:K>0</D:K>
</D:VY>
<D:ZAM>
<D:K>0</D:K>
</D:ZAM>
<D:LI>
<D:K>0</D:K>
</D:LI>
</D:SOR>
</D:ROR>
<D:RRZ>
<D:ZU>
<D:KZU>310004</D:KZU>
<D:NZU>Úřad městské části Praha 4</D:NZU>
</D:ZU>
<D:FU>
<D:KFU>4</D:KFU>
<D:NFU>Praha 4</D:NFU>
</D:FU>
</D:RRZ>
<D:KPP zdroj="RES">250 - 499 zaměstnanců</D:KPP>
<D:Nace>
<D:NACE zdroj="RES">181</D:NACE>
<D:NACE zdroj="RES">261</D:NACE>
<D:NACE zdroj="RES">26300</D:NACE>
<D:NACE zdroj="RES">43210</D:NACE>
<D:NACE zdroj="RES">461</D:NACE>
<D:NACE zdroj="RES">46900</D:NACE>
<D:NACE zdroj="RES">47</D:NACE>
<D:NACE zdroj="RES">52290</D:NACE>
<D:NACE zdroj="RES">5590</D:NACE>
<D:NACE zdroj="RES">61</D:NACE>
<D:NACE zdroj="RES">620</D:NACE>
<D:NACE zdroj="RES">63</D:NACE>
<D:NACE zdroj="RES">6820</D:NACE>
<D:NACE zdroj="RES">69200</D:NACE>
<D:NACE zdroj="RES">711</D:NACE>
<D:NACE zdroj="RES">7120</D:NACE>
<D:NACE zdroj="RES">73120</D:NACE>
<D:NACE zdroj="RES">73200</D:NACE>
<D:NACE zdroj="RES">74</D:NACE>
<D:NACE zdroj="RES">74300</D:NACE>
<D:NACE zdroj="RES">80</D:NACE>
<D:NACE zdroj="RES">80200</D:NACE>
<D:NACE zdroj="RES">8559</D:NACE>
</D:Nace>
<D:PPI>
<D:PP zdroj="OR">
<D:T>
Činnost účetních poradců, vedení účetnictví, vedení daňové evidence
</D:T>
<D:T>
pronájem nemovitostí, bytů a nebytových prostor s poskytováním jen základních služeb zajišťujících řádný provoz nemovitostí, bytů a nebytových prostor
</D:T>
<D:T>
Montáž, opravy, revize a zkoušky elektrických zařízení
</D:T>
<D:T>
Výroba, obchod a služby neuvedené v přílohách 1 až 3 živnostenského zákona
</D:T>
<D:T>
Výroba, instalace, opravy elektrických strojů a přístrojů, elektronických a telekomunikačních zařízení
</D:T>
<D:T>
poskytování technických služeb k ochraně majetku a osob
</D:T>
</D:PP>
<D:PP zdroj="RZP">
<D:T>Výroba, instalace, opravy elektrických strojů a přístrojů, elektronických a telekomunikačních zařízení</D:T>
<D:T>Poskytování technických služeb k ochraně majetku a osob</D:T>
<D:T>Výroba, obchod a služby neuvedené v přílohách 1 až 3 živnostenského zákona</D:T>
<D:T>Činnost účetních poradců, vedení účetnictví, vedení daňové evidence</D:T>
<D:T>Montáž, opravy, revize a zkoušky elektrických zařízení</D:T>
</D:PP>
</D:PPI>
<D:Obory_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01014</D:K>
<D:T>Vydavatelské činnosti, polygrafická výroba, knihařské a kopírovací práce</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01047</D:K>
<D:T>Zprostředkování obchodu a služeb</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01048</D:K>
<D:T>Velkoobchod a maloobchod</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01052</D:K>
<D:T>Skladování, balení zboží, manipulace s nákladem a technické činnosti v dopravě</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01053</D:K>
<D:T>Zasilatelství a zastupování v celním řízení</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01055</D:K>
<D:T>Ubytovací služby</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01056</D:K>
<D:T>Poskytování software, poradenství v oblasti informačních technologií, zpracování dat, hostingové a související činnosti a webové portály</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01060</D:K>
<D:T>Poradenská a konzultační činnost, zpracování odborných studií a posudků</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01062</D:K>
<D:T>Příprava a vypracování technických návrhů, grafické a kresličské práce</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01063</D:K>
<D:T>Projektování elektrických zařízení</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01064</D:K>
<D:T>Výzkum a vývoj v oblasti přírodních a technických věd nebo společenských věd</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01065</D:K>
<D:T>Testování, měření, analýzy a kontroly</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01066</D:K>
<D:T>Reklamní činnost, marketing, mediální zastoupení</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01070</D:K>
<D:T>Služby v oblasti administrativní správy a služby organizačně hospodářské povahy</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01072</D:K>
<D:T>Mimoškolní výchova a vzdělávání, pořádání kurzů, školení, včetně lektorské činnosti</D:T>
</D:Obor_cinnosti>
<D:Obor_cinnosti>
<D:K>Z01080</D:K>
<D:T>Výroba, obchod a služby jinde nezařazené</D:T>
</D:Obor_cinnosti>
</D:Obory_cinnosti>
</D:VBAS>
</are:Odpoved>
</are:Ares_odpovedi>'
        );

        /** @var SimpleXMLElement $xml */
        Assert::type(SimpleXMLElement::class, $xml);

        $aresEntity = $this->mapper->map($xml, '27074358');

        Assert::notNull($aresEntity);
        Assert::type(Ares\Entity\Ares::class, $aresEntity);

        Assert::equal('1056', $aresEntity->address->houseNumber);
        Assert::equal('5', $aresEntity->address->referenceNumber);
    }
}

$test = new MapperTest;
$test->run();
