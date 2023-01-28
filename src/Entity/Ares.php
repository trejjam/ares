<?php
declare(strict_types=1);

namespace Trejjam\Ares\Entity;

use DateTimeImmutable;

class Ares
{
    public function __construct(
        public readonly string $ico,
        public readonly null|string $dic,
        public readonly string $name,
        public readonly DateTimeImmutable $dateEstablishment,
        public readonly LegalForm $legalForm,
        public readonly Address $address
    ) {
    }
}
