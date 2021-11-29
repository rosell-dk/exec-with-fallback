<?php
namespace ExecWithFallback\Tests;

use PHPUnit\Framework\TestCase;


class PassthruTest extends BaseTest
{

    public $className = 'Passthru';

    public function isAvailable()
    {
        return function_exists('passthru');      
    }
}
