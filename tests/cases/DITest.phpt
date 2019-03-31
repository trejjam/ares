<?php
declare(strict_types=1);

namespace Trejjam\Ares\Tests;

use Composer\CaBundle\CaBundle;
use GuzzleHttp;
use Nette;
use Nette\DI\Compiler;
use Nette\DI\Definitions\Reference;
use Tester;
use Tester\Assert;
use Trejjam\Ares\Mapper;
use Trejjam\Ares\DI\AresExtension;
use Composer;

require __DIR__ . '/../bootstrap.php';

class DITest extends Tester\TestCase
{
	private const NAME = 'trejjam.ares';

    public function testConfig()
    {
    	$aresExtension = new AresExtension;

		$compiler = new Compiler;
		$compiler->addExtension(self::NAME, $aresExtension);

		$compiler->processExtensions();

        $aresConfig = $aresExtension->getConfig();

        Assert::same(Mapper::class, $aresConfig->mapper);
        Assert::null($aresConfig->http->clientFactory);
        Assert::same(['verify' => CaBundle::getSystemCaRootBundlePath()], $aresConfig->http->client);
    }

	public function testGuzzleFactory() : void
	{
		$aresExtension = new AresExtension;

		$compiler = new Compiler;
		$compiler->addExtension(self::NAME, $aresExtension);
		$compiler->addConfig(
			[
				self::NAME => [
					'http'   => [
						'clientFactory' => '@guzzleClassFactory',
					],
				],
			]
		);
		$containerBuilder = $compiler->getContainerBuilder();

		$guzzleClassFactory = $containerBuilder->addDefinition('guzzleClassFactory');
		$guzzleClassFactory->setType(GuzzleHttp\Client::class);

		$compiler->processExtensions();

		$aresExtension->beforeCompile();

		$aresConfig = $aresExtension->getConfig();

		Assert::same(Mapper::class, $aresConfig->mapper);
		Assert::same('@guzzleClassFactory', $aresConfig->http->clientFactory);
		Assert::same(['verify' => CaBundle::getSystemCaRootBundlePath()], $aresConfig->http->client);

		$httpClient = $containerBuilder->getDefinition(self::NAME . '.http.client');

		$httpClientServiceDefinition = $httpClient->getFactory()->getEntity();
		if ($httpClientServiceDefinition instanceof Reference) {
			Assert::same('guzzleClassFactory', $httpClientServiceDefinition->getValue());
		}
		else {
			// pre Nette 3.0 compatibility
			Assert::same('@guzzleClassFactory', $httpClientServiceDefinition);
		}
	}

	public function testGuzzleFactory2() : void
	{
		$aresExtension = new AresExtension;

		$compiler = new Compiler;
		$compiler->addExtension(self::NAME, $aresExtension);
		$compiler->addConfig(
			[
				self::NAME => [
					'http'   => [
						'clientFactory' => 'GuzzleHttp\Client([])',
					],
				],
			]
		);
		$containerBuilder = $compiler->getContainerBuilder();

		$compiler->processExtensions();

		$aresExtension->beforeCompile();

		$aresConfig = $aresExtension->getConfig();

		Assert::same(Mapper::class, $aresConfig->mapper);
		Assert::same('GuzzleHttp\Client([])', $aresConfig->http->clientFactory);
		Assert::same(['verify' => CaBundle::getSystemCaRootBundlePath()], $aresConfig->http->client);

		$containerBuilder = $compiler->getContainerBuilder();
		$containerBuilder = $compiler->getContainerBuilder();
		$httpClient = $containerBuilder->getDefinition(self::NAME . '.http.client');

		$httpClientServiceDefinition = $httpClient->getFactory()->getEntity();
		Assert::same('GuzzleHttp\Client([])', $httpClientServiceDefinition);
	}
}

$test = new DITest;
$test->run();
