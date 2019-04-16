<?php
declare(strict_types=1);

namespace Trejjam\Ares\DI;

use Composer;
use GuzzleHttp;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\DI\Definitions\Statement;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Nette\Utils\Strings;
use Trejjam\Ares;

/**
 * @property ExtensionConfiguration $config
 * @method ExtensionConfiguration getConfig()
 */
class AresExtension extends CompilerExtension
{
    public function __construct()
    {
        $this->config = new ExtensionConfiguration();
    }

    public function getConfigSchema() : Schema
    {
        return Expect::from($this->config);
    }

    public function loadConfiguration() : void
    {
        if ($this->config->http->caChain === null && method_exists(
            'Composer\CaBundle\CaBundle',
            'getSystemCaRootBundlePath'
        )) {
            $this->config->http->caChain = Composer\CaBundle\CaBundle::getSystemCaRootBundlePath();
        }
    }

    public function beforeCompile() : void
    {
        parent::beforeCompile();

        $builder = $this->getContainerBuilder();

        $this->registerFactory('mapper', Ares\IMapper::class, $this->config->mapper);

        if ($this->config->http->clientFactory !== null) {
            $httpClient = $this->registerFactory(
                'http.client',
                GuzzleHttp\Client::class,
                $this->config->http->clientFactory
            );
        } else {
            $httpClient = $builder->addDefinition($this->prefix('http.client'))->setType(GuzzleHttp\Client::class);
        }

        if ($this->config->http->caChain !== null && !array_key_exists('verify', $this->config->http->client)) {
            $this->config->http->client['verify'] = $this->config->http->caChain;
        }

        $httpClient
            ->setArguments(
                [
                    'config' => $this->config->http->client,
                ]
            )
            ->setAutowired(false);

        $builder
            ->addDefinition($this->prefix('request'))
            ->setFactory(Ares\Request::class)->setArguments(
                [
                    'httpClient' => $httpClient,
                ]
            );
    }

    /**
     * @param string|array|Statement $factory
     */
    private function registerFactory(string $name, string $type, $factory) : ServiceDefinition
    {
        $builder = $this->getContainerBuilder();

        if (is_string($factory) && Strings::startsWith($factory, '@')) {
            $factoryDefinition = $builder->addDefinition($this->prefix($name));

            $factoryDefinition->setFactory($factory);
        } else {
            $this->loadDefinitionsFromConfig(
                [
                    $name => $factory,
                ]
            );

            $factoryDefinition = $builder->getDefinition($this->prefix($name));
        }

        assert($factoryDefinition instanceof ServiceDefinition);

        $factoryDefinition->setType($type);

        return $factoryDefinition;
    }
}
