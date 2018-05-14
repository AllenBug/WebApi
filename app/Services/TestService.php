<?php
/**
 * Created by PhpStorm.
 * User: hchen
 * Date: 2018/5/8
 * Time: 17:36
 */
namespace App\Services;
use \App\Contracts\TestContract;

class TestService implements TestContract{
    public function  callMe($controller)
    {
        dd(111);
    }
}