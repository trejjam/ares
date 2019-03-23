<?php
declare(strict_types=1);

namespace Trejjam\Ares\DI;

use Composer\CaBundle\CaBundle;
use GuzzleHttp;
use Nette\DI\Compiler;
use Nette\Utils\Strings;
use Nette\Utils\Validators;
use Trejjam\Ares;
use Trejjam\BaseExtension\DI\BaseExtension;

class AresExtension extends BaseExtension
{
	protected $default = [
		'mapper' => Ares\Mapper::class,
		'http'   => [
			'clientFactory' => null,
			'client' => [
				'verify' => NULL, //NULL will be filled by Composer CA
			],
		],
	];

	protected $classesDefinition = [
		'http.client' => GuzzleHttp\Client::class,
		'request'     => Ares\Request::class,
	];

	public function __construct()
	{
		$this->default['http']['client']['verify'] = CaBundle::getSystemCaRootBundlePath();
	}

	public function loadConfiguration(bool $validateConfig = TRUE) : void
    {
        parent::loadConfiguration();

        Validators::assert($this->config['http']['clientFactory'], 'null|string|array|Nette\DI\Statement', 'http.client');
    }

    public function beforeCompile() : void
    {
        parent::beforeCompile();

		$builder = $this->getContainerBuilder();
		$types = $this->getTypes();

		$builder->addDefinition('mapper')
				->setFactory($this->config['mapper'])
				->setType(Ares\IMapper::class);

		if ($this->config['http']['clientFactory']!==null) {
            if (is_string($this->config['http']['clientFactory']) && Strings::startsWith($this->config['http']['clientFactory'], '@')) {
                $types['http.client']->setFactory($this->config['http']['clientFactory']);
            }
            else {
                Compiler::loadDefinition($types['http.client'], $this->config['http']['clientFactory']);
            }
        }

		$types['http.client']->setArguments(
			[
				'config' => $this->config['http']['client'],
			]
		)->setAutowired(FALSE);

		$types['request']->setArguments(
			[
				'httpClient' => $this->prefix('@http.client'),
			]
		);
	}
}
