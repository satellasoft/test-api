<?php

namespace App\Model;

use App\_Interface\IAccount;
use App\Classes\Account;

class AccountModel implements IAccount
{

    public function getAccountById(int $id): ?Account
    {
        $accounts = $this->getData();

        foreach ($accounts as $account) {
            if ($id == $account['id']) {
                return new Account($account['id'], $account['amount']);
            }
        }

        return null;
    }

    public function setAccount(Account $account): bool
    {
        $accouts = $this->getData();

        $accouts[] = [
            'id'     => $account->getId(),
            'amount' => $account->getAmount()
        ];

        if (!$this->saveData($accouts))
            return false;

        return true;
    }

    public function updateAmountAccount(Account $account, bool $add = true): bool
    {
        $accounts = $this->getData();

        for ($i = 0; $i < count($accounts); $i++) {

            if ($account->getId() == $accounts[$i]['id']) {

                if ($add)
                    $accounts[$i]['amount'] += $account->getAmount();
                else
                    $accounts[$i]['amount'] -= $account->getAmount();

                $this->saveData($accounts);

                return true;
            }
        }

        return false;
    }

    public function updateTransfer(Account $origin, Account $destination): bool
    {

        $accounts = $this->getData();

        for ($i = 0; count($accounts); $i++) {
            if ($accounts[$i]['id'] == $origin->getId()) {
                $accounts[$i] = [
                    'id'     => $origin->getId(),
                    'amount' => $origin->getAmount()
                ];
            }

            if ($accounts[$i]['id'] == $destination->getId()) {
                $accounts[$i] = [
                    'id'     => $destination->getId(),
                    'amount' => $destination->getAmount()
                ];
            }
        }

        $this->saveData($accounts);

        return true;
    }

    ############# INTERNAL METHODS #############
    private function getData()
    {
        $data = file_get_contents(PATH_FILE);

        return json_decode($data, true);
    }

    private function saveData(array $data): bool
    {
        try {
            file_put_contents(PATH_FILE, json_encode($data));
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }
}
