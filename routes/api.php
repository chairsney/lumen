<?php
/**
 *Author：LUCAS
 *DateTime:2021/6/22 18:59
 *Description:
 */

$app->group(['namespace' => 'V1','prefix' => 'v1'], function () use ($app){

    $app->get('get_version', function () use ($app) {
        return $app->version();
    });
    $app->get('key', function () use ($app) {
        return str_random(32);
    });
});