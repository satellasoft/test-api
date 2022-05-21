<?php

namespace App\Controller;

use App\Classes\Account;
use App\Helpers\Input;
use App\Model\AccountModel;

/**
 * Manager Event requests
 */
class EventController
{
    const DEPOSIT  = 'deposit';
    const WITHDRAW = 'withdraw';
    const TRANSFER = 'transfer';

    public function index()
    {
        $raw = Input::getRaw();

        if ($raw == null || !isset($raw['type'])) {
            return responseJson([], 404);
        }

        switch ($raw['type']) {
            case self::DEPOSIT:
                return self::deposit($raw);
                break;

            case self::WITHDRAW:
                return self::withdraw($raw);
                return;
                break;

            case self::TRANSFER:
                return self::transfer($raw);
                break;

            default:
                return responseJson([], 404);

                break;
        }
    }

    private function deposit(array $raw): bool
    {
        if ((!isset($raw['destination']) || $raw['destination'] == null) || (!isset($raw['amount']) || $raw['amount'] == null)) {

            responseJson(0, 404);
            return false;
        }

        $accountModel = new AccountModel();

        $exists = $accountModel->getAccountById($raw['destination']);

        $account = new Account($raw['destination'], $raw['amount']);

        //If not exists, then create
        if ($exists == null) {
            if ($accountModel->setAccount($account)) {
                $account = $accountModel->getAccountById($raw['destination']);

                responseJson(
                    ['destination' => [
                        'id'     => $account->getId(),
                        'amount' => $account->getAmount()
                    ]],
                    201
                );

                return true;
            }
        }

        if ($accountModel->updateAmountAccount($account)) {
            $account = $accountModel->getAccountById($raw['destination']);

            responseJson(
                ['destination' => [
                    'id'     => $account->getId(),
                    'amount' => $account->getAmount()
                ]],
                201
            );

            return true;
        }

        responseJson([], 422);
        return false;
    }

    private function withdraw(array $raw): bool
    {
        if ((!isset($raw['origin']) || $raw['origin'] == null) || (!isset($raw['amount']) || $raw['amount'] == null)) {
            responseJson(0, 404);
            return false;
        }

        $accountModel = new AccountModel();

        $acount = $accountModel->getAccountById($raw['origin']);

        if ($acount == null) {
            responseJson(0, 404);
            return false;
        }

        $account = new Account($raw['origin'], $raw['amount']);

        if ($accountModel->updateAmountAccount($account, false)) {
            $account = $accountModel->getAccountById($raw['origin']);

            responseJson(
                ['origin' => [
                    'id'     => $account->getId(),
                    'balance' => $account->getAmount()
                ]],
                201
            );

            return true;
        }

        responseJson([], 422);
        return false;


        return true;
    }

    private function transfer(array $raw): bool
    {
        if ((!isset($raw['origin']) || $raw['origin'] == null) || (!isset($raw['destination']) || $raw['destination'] == null) || (!isset($raw['amount']) || $raw['amount'] == null)) {
            responseJson(0, 404);
            return false;
        }

        $accountModel = new AccountModel();

        //Check if origin not exists
        if ($accountModel->getAccountById($raw['origin']) == null) {
            responseJson(0, 404);
            return false;
        }

        //Check if destination not exists
        if ($accountModel->getAccountById($raw['destination']) == null) {
            responseJson(0, 404);
            return false;
        }

        $acountOrigin = new Account($raw['origin']);
        $acountDestination = new Account($raw['destination']);

        $acountOrigin->setAmount($acountOrigin->getAmount() - $raw['amount']);

        $acountDestination->setAmount($acountDestination->getAmount() + $raw['amount']);

        if (!$accountModel->updateTransfer($acountOrigin, $acountDestination)) {
            responseJson(0, 404);
            return false;
        }
    }
}
