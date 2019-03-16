<?php

namespace App\Entities;

/**
 * Class Entity
 * @package App\Entities
 */
abstract class Entity
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * Entity constructor.
     * @param int $id
     */
    public function __construct(int $id = null)
    {
        if (!empty($id)) {
            $this->setId($id);
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    private function setId(int $id): void
    {
        $this->id = $id;
    }
}