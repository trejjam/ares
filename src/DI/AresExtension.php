<?php
declare(strict_types=1);

namespace Trejjam\Ares\DI;

use Composer;
use GuzzleHttp;
use Trejjam;

class AresExtension extends Trejjam\BaseExtension\DI\BaseExtension
{
	protected $default = [
		'http' => [
			'client' => [
				'verify' => NULL, //NULL will be filled by Composer CA
			],
		],
	];

	protected $classesDefinition = [
		'http.client' => GuzzleHttp\Client::class,
		'request'     => Trejjam\Ares\Request::class,
	];

	public function __construct()
	{
		$this->default['http']['client']['verify'] = Composer\CaBundle\CaBundle::getSystemCaRootBundlePath();
	}

	public function loadConfiguration()
	{
		parent::loadConfiguration();

		$config = $this->createConfig();

		$classes = $this->getClasses();

		$classes['http.client']->setArguments(
			[
				'config' => $config['http']['client'],
			]
		)->setAutowired(FALSE);

		$classes['request']->setArguments(
			[
				'httpClient' => $this->prefix('@http.client'),
			]
		);
	}
}
