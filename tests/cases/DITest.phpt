<?php
declare(strict_types=1);

namespace Trejjam\Ares\Tests;

use Nette;
use Tester;
use Tester\Assert;
use Trejjam\Ares;
use Composer;

require __DIR__ . '/../bootstrap.php';

class DITest extends Tester\TestCase
{
    public function testConfig()
    {
        $aresExtension = new Ares\DI\AresExtension;

        $aresExtension->setCompiler(new Nette\DI\Compiler, 'container_' . __FUNCTION__);
        $aresExtension->loadConfiguration();
        $aresConfig = $aresExtension->getConfig();

        Assert::same(
            [
                'mapper' => Ares\Mapper::class,
                'http'   => [
                    'clientFactory' => null,
                    'client'        => ['verify' => Composer\CaBundle\CaBundle::getSystemCaRootBundlePath()],
                ],
            ], $aresConfig
        );
    }
}

$test = new DITest;
$test->run();
