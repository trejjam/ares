<?php
declare(strict_types=1);

namespace Trejjam\Ares\Tests;

use Composer;
use GuzzleHttp;
use SimpleXMLElement;
use Tester;
use Tester\Assert;
use Trejjam\Ares;

require __DIR__ . '/../bootstrap.php';

class RequestTest extends Tester\TestCase
{
    private Ares\Request $aresRequest;

    protected function setUp() : void
    {
        $httpClient = new GuzzleHttp\Client(
            [
                'verify' => Composer\CaBundle\CaBundle::getSystemCaRootBundlePath(),
            ]
        );
        $mapper = new Ares\Mapper;

        $this->aresRequest = new Ares\Request(
            $httpClient,
            $mapper
        );
    }

    public function testFetchValidIco() : void
    {
        $validIcoFetch = $this->aresRequest->fetch('27074358');
        Assert::notNull($validIcoFetch);
        Assert::type(SimpleXMLElement::class, $validIcoFetch);
    }

    public function testFetchInvalidIco() : void
    {
        $invalidIcoFetch = $this->aresRequest->fetch('27074357');
        Assert::notNull($invalidIcoFetch);
        Assert::type(SimpleXMLElement::class, $invalidIcoFetch);
    }

    public function testFetchAndMapValidIco() : void
    {
        $ares = $this->aresRequest->getResponse('27074358');
        Assert::notNull($ares);
        Assert::type(Ares\Entity\Ares::class, $ares);

        $address = $ares->address;
        $legalForm = $ares->legalForm;

        Assert::type(Ares\Entity\Address::class, $address);
        Assert::type(Ares\Entity\LegalForm::class, $legalForm);
    }

    public function testFetchAndMapInvalidIco() : void
    {
        Assert::throws(function () {
            $this->aresRequest->getResponse('27074357');
        }, Ares\IcoNotFoundException::class, 'Chyba 71 - nenalezeno 27074357', 1);
    }
}

$test = new RequestTest;
$test->run();
