<?php
declare(strict_types=1);

namespace Trejjam\Ares\Tests;

use Composer;
use Exception;
use GuzzleHttp;
use SimpleXMLElement;
use Tester;
use Tester\Assert;
use Trejjam\Ares;

require __DIR__ . '/../bootstrap.php';

class RequestTest extends Tester\TestCase
{
    private null|Ares\Request $aresRequest;

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

    /**
     * @throws Exception
     */
    public function testConfig() : void
    {
        $validIcoFetch = $this->aresRequest->fetch('27074358');
        Assert::type(SimpleXMLElement::class, $validIcoFetch);

        $invalidIcoFetch = $this->aresRequest->fetch('27074357');
        Assert::type(SimpleXMLElement::class, $invalidIcoFetch);

        /** @var Ares\Entity\Ares $ares */
        $ares = $this->aresRequest->getResponse('27074358');
        Assert::type(Ares\Entity\Ares::class, $ares);

        $address = $ares->getAddress();
        $legalForm = $ares->getLegalForm();

        Assert::type(Ares\Entity\Address::class, $address);
        Assert::type(Ares\Entity\LegalForm::class, $legalForm);

        Assert::throws(function () {
            $this->aresRequest->getResponse('27074357');
        }, Ares\IcoNotFoundException::class, 'Chyba 71 - nenalezeno 27074357', 1);
    }
}

$test = new RequestTest;
$test->run();
