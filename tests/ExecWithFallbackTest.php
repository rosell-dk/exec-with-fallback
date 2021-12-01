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

    public function testAnyMethodAvailable()
    {
        $methods = ['exec', 'passthru', 'popen', 'proc_open', 'shell_exec'];
        $anyAvailable = false;
        $anyOtherThanShellExecAvailable = false;
        foreach ($methods as $method) {
            if (function_exists($method)) {
                $anyAvailable = true;
                if ($method != 'shell_exec') {
                    $anyOtherThanShellExecAvailable = true;
                }
            }
        }

        $this->assertSame($anyAvailable, ExecWithFallback::anyAvailable(false));
        $this->assertSame($anyOtherThanShellExecAvailable, ExecWithFallback::anyAvailable(true));
        $this->assertSame($anyOtherThanShellExecAvailable, ExecWithFallback::anyAvailable());
    }

}
