<?php

namespace Core\DTO;

class AccountDTO
{
    public string $id;

    public function __construct()
    {
    }

    function getId(): string
    {
        return $this->id;
    }

    function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
}
