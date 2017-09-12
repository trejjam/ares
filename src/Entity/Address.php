<?php
declare(strict_types=1);

namespace Trejjam\Ares\Entity;

class Address
{
	/**
	 * @var int
	 */
	private $id;
	/**
	 * @var int
	 */
	private $stateId;
	/**
	 * @var string
	 */
	private $district;
	/**
	 * @var string
	 */
	private $village;
	/**
	 * @var string
	 */
	private $villagePart;
	/**
	 * @var string
	 */
	private $townPart;
	/**
	 * @var string
	 */
	private $street;
	/**
	 * @var string
	 */
	private $houseNumber;
	/**
	 * @var string
	 */
	private $referenceNumber;
	/**
	 * @var int
	 */
	private $zip;

	public function __construct(
		int $id,
		int $stateId,
		string $district,
		string $village,
		string $villagePart,
		string $townPart,
		string $street,
		string $houseNumber,
		string $referenceNumber,
		int $zip
	) {
		$this->id = $id;
		$this->stateId = $stateId;
		$this->district = $district;
		$this->village = $village;
		$this->villagePart = $villagePart;
		$this->townPart = $townPart;
		$this->street = $street;
		$this->houseNumber = $houseNumber;
		$this->referenceNumber = $referenceNumber;
		$this->zip = $zip;
	}

	public function getId() : int
	{
		return $this->id;
	}

	public function getStateId() : int
	{
		return $this->stateId;
	}

	public function getDistrict() : string
	{
		return $this->district;
	}

	public function getVillage() : string
	{
		return $this->village;
	}

	public function getVillagePart() : string
	{
		return $this->villagePart;
	}

	public function getTownPart() : string
	{
		return $this->townPart;
	}

	public function getStreet() : string
	{
		return $this->street;
	}

	public function getHouseNumber() : string
	{
		return $this->houseNumber;
	}

	public function getReferenceNumber() : string
	{
		return $this->referenceNumber;
	}

	public function getZip() : int
	{
		return $this->zip;
	}
}
