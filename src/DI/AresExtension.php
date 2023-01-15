<?php
declare(strict_types=1);

namespace Trejjam\Ares\DI;

use Composer;
use GuzzleHttp;
use Nette;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\DI\Definitions\Statement;
use Nette\Schema\Expect;
use Nette\Utils\Strings;
use stdClass;
use Trejjam\Ares;
use Trejjam\Ares\Mapper;

/**
 * @property-read stdClass $config
 */
class AresExtension extends CompilerExtension
{
    public function getConfigSchema() : Nette\Schema\Schema
    {
        return Expect::structure([
            'http' => Expect::structure([
                'clientFactory' => Expect::anyOf(Expect::string(), Expect::array(), Expect::type(Statement::class))->nullable(),
                'caChain' => Expect::anyOf(Expect::string(), Expect::type(Statement::class))->nullable(),
                'client' => Expect::array()->default([]),
            ]),
            'mapper' => Expect::anyOf(Expect::string(), Expect::array(), Expect::type(Statement::class))->default(Mapper::class),
        ]);
    }

    public function loadConfiguration() : void
    {
        $http = $this->config->http;
        if ($http->caChain === null && method_exists(
            'Composer\CaBundle\CaBundle',
            'getSystemCaRootBundlePath'
        )) {
            $http->caChain = Composer\CaBundle\CaBundle::getSystemCaRootBundlePath();
        }
    }

    public function beforeCompile() : void
    {
        parent::beforeCompile();

        $builder = $this->getContainerBuilder();

        $mapper = $this->config->mapper;
        $http = $this->config->http;

        $this->registerFactory('mapper', Ares\IMapper::class, $mapper);

        if ($http->clientFactory !== null) {
            $httpClient = $this->registerFactory(
                'http.client',
                GuzzleHttp\Client::class,
                $http->clientFactory
            );
        }
        else {
            $httpClient = $builder->addDefinition($this->prefix('http.client'))->setType(GuzzleHttp\Client::class);
        }

        if ($http->caChain !== null && !array_key_exists('verify', $http->client)) {
            $http->client['verify'] = $http->caChain;
        }

        $httpClient
            ->setArguments(['config' => $http->client])
            ->setAutowired(false);

        $builder
            ->addDefinition($this->prefix('request'))
            ->setFactory(Ares\Request::class)->setArguments(['httpClient' => $httpClient]);
    }

    private function registerFactory(string $name, string $type, string|array|Statement $factory) : ServiceDefinition
    {
        $builder = $this->getContainerBuilder();

        if (is_string($factory) && Strings::startsWith($factory, '@')) {
            $factoryDefinition = $builder->addDefinition($this->prefix($name));

            $factoryDefinition->setFactory($factory);
        }
        else {
            $this->loadDefinitionsFromConfig([$name => $factory]);

            $factoryDefinition = $builder->getDefinition($this->prefix($name));
        }

        assert($factoryDefinition instanceof ServiceDefinition);

        $factoryDefinition->setType($type);

        return $factoryDefinition;
    }
}
