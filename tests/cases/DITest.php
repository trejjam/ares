<?php
declare(strict_types=1);

namespace Trejjam\Ares\Tests;

use Composer\CaBundle\CaBundle;
use GuzzleHttp;
use Nette;
use Nette\DI\Compiler;
use Nette\DI\Definitions\Reference;
use Nette\DI\Definitions\ServiceDefinition;
use stdClass;
use Tester\Assert;
use Tester\TestCase;
use Trejjam\Ares\DI\AresExtension;
use Trejjam\Ares\Mapper;

require __DIR__ . '/../bootstrap.php';

class DITest extends TestCase
{
    private const NAME = 'trejjam.ares';

    public function testConfig() : void
    {
        $aresExtension = new AresExtension;

        $compiler = new Compiler;
        $compiler->addExtension(self::NAME, $aresExtension);

        $compiler->processExtensions();

        /** @var stdClass $aresConfig */
        $aresConfig = $aresExtension->getConfig();

        Assert::same(Mapper::class, $aresConfig->mapper);
        Assert::null($aresConfig->http->clientFactory);
        Assert::same(CaBundle::getSystemCaRootBundlePath(), $aresConfig->http->caChain);

        Assert::same([], $aresConfig->http->client);
    }

    public function testGuzzleFactory() : void
    {
        $aresExtension = new AresExtension;

        $compiler = new Compiler;
        $compiler->addExtension(self::NAME, $aresExtension);
        $compiler->addConfig(
            [
                self::NAME => [
                    'http' => [
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

        /** @var stdClass $aresConfig */
        $aresConfig = $aresExtension->getConfig();

        Assert::same(Mapper::class, $aresConfig->mapper);
        Assert::same('@guzzleClassFactory', $aresConfig->http->clientFactory);

        Assert::same(CaBundle::getSystemCaRootBundlePath(), $aresConfig->http->caChain);
        Assert::same(['verify' => CaBundle::getSystemCaRootBundlePath()], $aresConfig->http->client);

        $httpClient = $containerBuilder->getDefinition(self::NAME . '.http.client');
        \assert($httpClient instanceof ServiceDefinition);

        $httpClientServiceDefinition = $httpClient->getFactory()->getEntity();
        \assert($httpClientServiceDefinition instanceof Reference);
        Assert::same('guzzleClassFactory', $httpClientServiceDefinition->getValue());
    }

    public function testGuzzleFactory2() : void
    {
        $aresExtension = new AresExtension;

        $compiler = new Compiler;
        $compiler->addExtension(self::NAME, $aresExtension);
        $compiler->addConfig(
            [
                self::NAME => [
                    'http' => [
                        'clientFactory' => 'GuzzleHttp\Client([])',
                    ],
                ],
            ]
        );
        $containerBuilder = $compiler->getContainerBuilder();

        $compiler->processExtensions();

        $aresExtension->beforeCompile();

        /** @var stdClass $aresConfig */
        $aresConfig = $aresExtension->getConfig();

        Assert::same(Mapper::class, $aresConfig->mapper);
        Assert::same('GuzzleHttp\Client([])', $aresConfig->http->clientFactory);

        Assert::same(CaBundle::getSystemCaRootBundlePath(), $aresConfig->http->caChain);
        Assert::same(['verify' => CaBundle::getSystemCaRootBundlePath()], $aresConfig->http->client);

        $containerBuilder = $compiler->getContainerBuilder();
        $containerBuilder = $compiler->getContainerBuilder();
        $httpClient = $containerBuilder->getDefinition(self::NAME . '.http.client');
        \assert($httpClient instanceof ServiceDefinition);

        $httpClientServiceDefinition = $httpClient->getFactory()->getEntity();
        Assert::same('GuzzleHttp\Client([])', $httpClientServiceDefinition);
    }

    public function testCertainityCaChainFactory() : void
    {
        $aresExtension = new AresExtension;

        $compiler = new Compiler;
        $compiler->addExtension(self::NAME, $aresExtension);
        $compiler->addConfig(
            [
                self::NAME => [
                    'http' => [
                        'caChain' => 'ParagonIE\Certainty\RemoteFetch()::getLatestBundle()::getFilePath()',
                    ],
                ],
            ]
        );
        $containerBuilder = $compiler->getContainerBuilder();

        $compiler->processExtensions();

        $aresExtension->beforeCompile();

        /** @var stdClass $aresConfig */
        $aresConfig = $aresExtension->getConfig();

        Assert::same(Mapper::class, $aresConfig->mapper);
        Assert::null($aresConfig->http->clientFactory);

        Assert::same('ParagonIE\Certainty\RemoteFetch()::getLatestBundle()::getFilePath()', $aresConfig->http->caChain);
        Assert::same(
            ['verify' => 'ParagonIE\Certainty\RemoteFetch()::getLatestBundle()::getFilePath()'],
            $aresConfig->http->client
        );

        $httpClient = $containerBuilder->getDefinition(self::NAME . '.http.client');
        assert($httpClient instanceof Nette\DI\Definitions\ServiceDefinition);

        Assert::same($aresConfig->http->client['verify'], $httpClient->getFactory()->arguments['config']['verify']);
    }
}

$test = new DITest;
$test->run();
