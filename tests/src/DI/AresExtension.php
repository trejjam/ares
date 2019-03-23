<?php
declare(strict_types=1);

namespace Trejjam\Ares\Tests\DI;

use Trejjam\Ares;

class AresExtension extends Ares\DI\AresExtension
{
	public function createConfig() : array
	{
		return parent::createConfig();
	}
}
