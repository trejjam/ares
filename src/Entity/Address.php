<?php
declare(strict_types=1);

namespace Trejjam\Ares\Entity;

class Address
{
    public function __construct(
        public readonly int $id,
        public readonly int $stateId,
        public readonly string $district,
        public readonly string $village,
        public readonly string $villagePart,
        public readonly string $townPart,
        public readonly string $street,
        public readonly string $houseNumber,
        public readonly string $referenceNumber,
        public readonly int $zip
    ) {
    }
}
