<?php
declare(strict_types=1);

namespace Trejjam\Ares\DI;

use GuzzleHttp;
use Nette\DI\Compiler;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Nette\Utils\Strings;
use Nette\Utils\Validators;
use Trejjam\Ares;
use Trejjam\BaseExtension\DI\BaseExtension;

/**
 * @property ExtensionConfiguration $config
 */
class AresExtension extends BaseExtension
{
    protected $classesDefinition = [
        'http.client' => GuzzleHttp\Client::class,
        'request'     => Ares\Request::class,
    ];

    /**
     * pre Nette 3.0 compatibility
     *
     * @var ExtensionConfiguration
     */
    private $shadowConfig;

    public function __construct()
    {
        $this->config = new ExtensionConfiguration();

        if (!method_exists(parent::class, 'getConfigSchema')) {
            // pre Nette 3.0 compatibility
            $this->shadowConfig = $this->config;
            $this->config = [];
        }
    }

    public function getConfigSchema() : Schema
    {
        return Expect::from($this->config);
    }

    public function loadConfiguration(bool $validateConfig = true) : void
    {
        if (!method_exists(parent::class, 'getConfigSchema')) {
            // pre Nette 3.0 compatibility

            $config = (array)$this->shadowConfig;
            $config['http'] = (array)$this->shadowConfig->http;
            $this->validateConfig($config);

            Validators::assert($this->config['mapper'], 'string|array|Nette\DI\Statement', 'mapper');
            Validators::assert($this->config['http']['clientFactory'], 'null|string|array|Nette\DI\Statement', 'http.client');

            $this->config = (object) $this->config;
            $this->config->http = (object) $this->config->http;
        }
    }

    public function beforeCompile() : void
    {
        parent::loadConfiguration(false);

        parent::beforeCompile();

        $builder = $this->getContainerBuilder();
        $types = $this->getTypes();

        if (is_string($this->config->mapper) && Strings::startsWith($this->config->mapper, '@')) {
            $builder->addDefinition($this->prefix('mapper'))
                    ->setFactory($this->config->mapper);
        }
        else {
            if (!method_exists($this, 'loadDefinitionsFromConfig')) {
                // pre Nette 3.0 compatibility

                $mapper = $builder->addDefinition($this->prefix('mapper'));
                Compiler::loadDefinition($mapper, $this->config->mapper);
            }
            else {
                $this->loadDefinitionsFromConfig(
                    [
                        'mapper' => $this->config->mapper,
                    ]
                );
            }
        }

        $mapper = $builder->getDefinition($this->prefix('mapper'))
                ->setType(Ares\IMapper::class);

        if ($this->config->http->clientFactory !== null) {
            if (is_string($this->config->http->clientFactory) && Strings::startsWith($this->config->http->clientFactory, '@')) {
                $types['http.client']->setFactory($this->config->http->clientFactory);
            }
            else {
                if (!method_exists($this, 'loadDefinitionsFromConfig')) {
                    // pre Nette 3.0 compatibility

                    Compiler::loadDefinition($types['http.client'], $this->config->http->clientFactory);
                }
                else {
                    $this->loadDefinitionsFromConfig(
                        [
                            'http.client' => $this->config->http->clientFactory,
                        ]
                    );
                }
            }
        }

        $types['http.client']->setArguments(
            [
                'config' => $this->config->http->client,
            ]
        )->setAutowired(false);

        $types['request']->setArguments(
            [
                'httpClient' => $this->prefix('@http.client'),
            ]
        );
    }
}
