<?php
namespace ExecWithFallback\Tests;

use PHPUnit\Framework\TestCase;
use ExecWithFallback\ExecWithFallback;

class ExecWithFallbackTest extends BaseTest
{
    public $className = 'ExecWithFallback';

    public function isAvailable()
    {
        return
            function_exists('exec') ||
            function_exists('proc_open') ||
            function_exists('passthru') ||
            function_exists('popen') ||
            function_exists('shell_exec');
    }

    public function runExec($command, &$output = null, &$result_code = null)
    {
        return ExecWithFallback::exec($command, $output, $result_code);
    }


    public function testRunExec()
    {
        if (function_exists('exec')) {
            $result = ExecWithFallback::runExec('exec', 'echo hi');
            $this->assertEquals('hi', $result);
        }

        if (function_exists('shell_exec')) {
            $result = ExecWithFallback::runExec('shell_exec', 'echo hi', $output, $result_code);
            $this->assertFalse($result);
        }

    }

}
