<?php
declare(strict_types=1);

namespace Trejjam\Ares\DI;

use Nette\DI\Definitions\Statement;

final class HttpClientConfiguration
{
    /**
     * @var string|array|Statement|null
     */
    public $clientFactory = null;

    /**
     * @var string|Statement|null
     */
    public $caChain = null;

    /**
     * @var array
     */
    public $client = [];
}
