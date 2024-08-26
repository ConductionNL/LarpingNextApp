<?php

namespace OCA\OpenCatalogi\Db;

use DateTime;
use JsonSerializable;
use OCP\AppFramework\Db\Entity;

class Event extends Entity implements JsonSerializable
{

	protected ?string $id = null;
	protected ?string $name = null;
	protected ?string $description = null;
	protected ?array $players = [];
	protected ?array $effects = [];
	protected ?string $startDate = null;
	protected ?string $endDate = null;
	protected ?string $location = null;

	public function __construct() {
		$this->addType('id', 'string');
		$this->addType('name', 'string');
		$this->addType('description', 'string');
		$this->addType('players', 'array');
		$this->addType('effects', 'array');
		$this->addType('startDate', 'string');
		$this->addType('endDate', 'string');
		$this->addType('location', 'string');
	}

	public function jsonSerialize(): array
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'description' => $this->description,
			'players' => $this->players,
			'effects' => $this->effects,
			'startDate' => $this->startDate,
			'endDate' => $this->endDate,
			'location' => $this->location,
		];
	}
}