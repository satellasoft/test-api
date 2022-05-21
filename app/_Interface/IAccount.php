<?php

namespace App\_Interface;

use App\Classes\Account;

interface IAccount
{
    public function getAccountById(int $id): ?Account;

    public function setAccount(Account $account): bool;

    public function updateAmountAccount(Account $account): bool;

    public function updateTransfer(Account $origin, Account $destination) : bool;
}
