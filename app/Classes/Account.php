<?php

namespace App\Classes;

class Account
{
    private ?int $id;
    private float $amount;

    public function __construct(int $id = null, float $amount = 0)
    {
        $this->id = $id;
        $this->amount = $amount;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount) {
        $this->amount = $amount;
    }

}
