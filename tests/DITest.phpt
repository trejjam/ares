<?php
declare(strict_types=1);

namespace Trejjam\Ares\Tests;

use Nette;
use Tester;
use Tester\Assert;
use Trejjam\Ares;
use Composer;

require __DIR__ . '/bootstrap.php';

class DITest extends Tester\TestCase
{
	public function testConfig()
	{
		$aresExtension = new DI\AresExtension;

		$aresExtension->setCompiler(new Nette\DI\Compiler, 'container_' . __FUNCTION__);
		$mailChimpConfig = $aresExtension->createConfig();

		Assert::same(
			[
				'http' => [
					'client' => ['verify' => Composer\CaBundle\CaBundle::getSystemCaRootBundlePath()],
				],
			], $mailChimpConfig
		);
	}
}

$test = new DITest;
$test->run();
