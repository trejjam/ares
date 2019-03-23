<?php
declare(strict_types=1);

namespace Trejjam\Ares;

interface IMapper
{
    public function map(\SimpleXMLElement $xml, string $ico);
}
