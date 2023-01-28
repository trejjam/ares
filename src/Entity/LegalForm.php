<?php
declare(strict_types=1);

namespace Trejjam\Ares\Entity;

class LegalForm
{
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {
    }
}
