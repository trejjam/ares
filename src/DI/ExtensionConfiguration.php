<?php
declare(strict_types=1);

namespace Trejjam\Ares\DI;

use Nette\DI\Definitions\Statement;
use Trejjam\Ares\Mapper;

final class ExtensionConfiguration
{
    /**
     * @var string|array|Statement
     */
    public $mapper = Mapper::class;

    public HttpClientConfiguration $http;

    public function __construct()
    {
        $this->http = new HttpClientConfiguration();
    }
}
