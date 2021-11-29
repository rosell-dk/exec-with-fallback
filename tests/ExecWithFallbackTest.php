<?php
namespace ExecWithFallback\Tests;

use PHPUnit\Framework\TestCase;

class ExecWithFallbackTest extends BaseTest
{
    public $className = 'ExecWithFallback';

    public function isAvailable()
    {
        return
            function_exists('exec') ||
            function_exists('proc_open') ||
            function_exists('passthru');
    }

}
