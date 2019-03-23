<?php
declare(strict_types=1);

namespace Trejjam\Ares\Entity;

use DateTimeImmutable;

class Ares
{
    /**
     * @var string
     */
    private $ico;
    /**
     * @var string|null
     */
    private $dic;
    /**
     * @var string
     */
    private $name;
    /**
     * @var DateTimeImmutable
     */
    private $dateEstablishment;
    /**
     * @var LegalForm
     */
    private $legalForm;
    /**
     * @var Address
     */
    private $address;

    public function __construct(
        string $ico,
        ?string $dic,
        string $name,
        DateTimeImmutable $dateEstablishment,
        LegalForm $legalForm,
        Address $address
    ) {
        $this->ico = $ico;
        $this->dic = $dic;
        $this->name = $name;
        $this->dateEstablishment = $dateEstablishment;
        $this->legalForm = $legalForm;
        $this->address = $address;
    }

    public function getIco() : string
    {
        return $this->ico;
    }

    public function getDic() : ?string
    {
        return $this->dic;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getDateEstablishment() : DateTimeImmutable
    {
        return $this->dateEstablishment;
    }

    public function getLegalForm() : LegalForm
    {
        return $this->legalForm;
    }

    public function getAddress() : Address
    {
        return $this->address;
    }
}
