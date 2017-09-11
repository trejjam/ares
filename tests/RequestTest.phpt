<?php
declare(strict_types=1);

namespace Trejjam\Ares\Tests;

use Composer;
use GuzzleHttp;
use SimpleXMLElement;
use Tester;
use Tester\Assert;
use Trejjam\Ares;

require __DIR__ . '/bootstrap.php';

class RequestTest extends Tester\TestCase
{
	/**
	 * @var Ares\Request
	 */
	private $aresRequest;

	protected function setUp()
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

	public function testConfig()
	{
		$validIcoFetch = $this->aresRequest->fetch('27074358');
		Assert::type(SimpleXMLElement::class, $validIcoFetch);

		$invalidIcoFetch = $this->aresRequest->fetch('27074357');
		Assert::type(SimpleXMLElement::class, $invalidIcoFetch);

		$this->aresRequest->getResponse('27074358');

		Assert::throws(function () {
			$this->aresRequest->getResponse('27074357');
		}, Ares\IcoNotFoundException::class, 'Chyba 71 - nenalezeno 27074357', 1);
	}
}

$test = new RequestTest;
$test->run();
