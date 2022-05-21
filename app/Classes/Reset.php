<?php

namespace App\Classes;

/**
 * Manager Reset methods
 */
class Reset
{
    /**
     * Reset file data to default state
     *
     * @return bool
     */
    public function reset(): bool
    {
        try {
            $content = [
                [
                    'id'     => 300,
                    'amount' => 0
                ]
            ];

            $fp = fopen(PATH_FILE, 'w');

            fwrite($fp, json_encode($content));

            fclose($fp);

            responseJson([], 200);

            return true;
        } catch (\Exception $ex) {
            //$ex->getMessage();
            return false;
        }
    }
}
