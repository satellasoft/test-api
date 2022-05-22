<?php

namespace App\Controller;

use App\Helpers\Input;
use App\Model\AccountModel;

/**
 * Manager Balance requests
 */
class BalanceController
{
    
    /**
     * Get amount by ID acount
     *
     * @return void
     */
    public function getBalanceAmount()
    {
        $id = Input::get('account_id', FILTER_SANITIZE_NUMBER_INT);

        if (!$id || $id == null || $id <= 0)
            return responseJson(0, 404);

        $accountModel = new AccountModel();

        $acount = $accountModel->getAccountById($id);

        if ($acount == null || ($acount->getId() == null || $acount->getId() <= 0))
            return responseJson(0, 404);

        return responseJson($acount->getAmount(), 200);
    }
}
