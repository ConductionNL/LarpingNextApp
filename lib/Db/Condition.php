<?php

namespace OCA\OpenCatalogi\Db;

use DateTime;
use JsonSerializable;
use OCP\AppFramework\Db\Entity;

class Condition extends Entity implements JsonSerializable
{
    protected ?string $id = null;
    protected ?string $name = null;
    protected ?string $description = null;
    protected ?string $effect = null;
    protected ?array $effects = [];
    protected ?bool $unique = false;

    public function __construct() {
        $this->addType('id', 'string');
        $this->addType('name', 'string');
        $this->addType('description', 'string');
        $this->addType('effect', 'string');
        $this->addType('effects', 'array');
        $this->addType('unique', 'boolean');
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'effect' => $this->effect,
            'effects' => $this->effects,
            'unique' => $this->unique,
        ];
    }
}