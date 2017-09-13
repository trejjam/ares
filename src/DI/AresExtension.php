<?php
declare(strict_types=1);

namespace Trejjam\Ares\DI;

use Composer;
use GuzzleHttp;
use Trejjam;

class AresExtension extends Trejjam\BaseExtension\DI\BaseExtension
{
	protected $default = [
		'mapper' => Trejjam\Ares\Mapper::class,
		'http'   => [
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

		$builder = $this->getContainerBuilder();
		$classes = $this->getClasses();

		$builder->addDefinition('mapper')
				->setFactory($config['mapper'])
				->setType(Trejjam\Ares\IMapper::class);

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
