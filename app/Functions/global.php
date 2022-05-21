<?php

/**
 * Debug value
 *
 * @param  mixed $param Param to debug
 * @param  bool $die Kill application with parameter is true
 * @return void
 */
function dd($param = null, bool $die = true)
{
    echo '<pre>';
    print_r($param);
    echo '</pre>';

    if ($die)
        die();
}

/**
 * Response JSON with HTTP Status Code
 *
 * @param  mixed $content with response code
 * @param  int $statusCode HTTP Status Code
 * @return void
 */
function responseJson($content, int $statusCode = 200)
{
    header('Content-Type: application/json;charset=utf-8', true, $statusCode);

    if (is_array($content)) {
        echo json_encode($content);
        die;
    }

    echo $content;
    return;
}
