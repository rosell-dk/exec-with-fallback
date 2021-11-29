<?php
namespace ExecWithFallback\Tests;

use PHPUnit\Framework\TestCase;

use ExecWithFallback\ExecWithFallback;
use ExecWithFallback\ProcOpen;
use ExecWithFallback\Passthru;


class BaseTest extends TestCase
{
    public $className = '';

    public function runExec($command, &$output = null, &$return_code = null)
    {
      //echo "\n" . 'Running:' . $this->className;
        if ($this->className == 'ExecWithFallback') {
            return ExecWithFallback::exec($command, $output,$return_code);
        } elseif ($this->className == 'ProcOpen') {
            return ProcOpen::exec($command, $output,$return_code);
        } elseif ($this->className == 'Passthru') {
            return Passthru::exec($command, $output,$return_code);
        } else {
            //echo "\n" . 'RUNNING BASE EXEC';
            return exec($command, $output, $return_code);
        }

        /*
        return call_user_func(
            ['\\ExecWithFallback\\' . 'exec'],
            $command,
            $output,
            $return_code
        );
        */
    }

    /*
    Doesn't work with ProcOpen
    public function testDevNull()
    {
        $output = [];
        $execResult = $this->runExec('ls 1>/dev/null', $output, $return_code);
        $this->assertEquals(0, $return_code);
        $this->assertEquals(0, count($output));
        $this->assertEquals('', $execResult);
    }
    */


    public function testNoReturnCodeSupplied()
    {
        $output = [];
        $execResult = $this->runExec('echo hi', $output);
        $this->assertEquals('hi', $execResult);
    }

    public function testNoOutputSupplied()
    {
        $result = $this->runExec('echo hi');
        $this->assertEquals('hi', $result);
    }

    public function testTwoLines()
    {
        $result = $this->runExec('echo "hi" && echo "world"', $output, $return_code);
        $this->assertEquals(0, $return_code);
        $this->assertEquals('world', $result);
        $this->assertEquals(count($output), 2, print_r($output, true));
        $this->assertEquals($output[0], 'hi');
        $this->assertEquals($output[1], 'world');
    }

    public function testOutputIsInt()
    {
        $output = 10;
        $result = $this->runExec('echo "hi"', $output, $return_code);
        $this->assertEquals(0, $return_code);
        $this->assertEquals('hi', $result);
        $this->assertEquals('array', gettype($output));
        $this->assertEquals($output[0], 'hi');
    }

    public function testOutputIsString()
    {
        $output = 'abc';
        $result = $this->runExec('echo "hi"', $output, $return_code);
        $this->assertEquals(0, $return_code);
        $this->assertEquals('hi', $result);
        $this->assertEquals('array', gettype($output));
        $this->assertEquals('hi', $output[0]);
    }

    public function testOutputIsExistingArray()
    {
        $output = ['abc'];
        $result = $this->runExec('echo "hi"', $output, $return_code);
        $this->assertEquals(0, $return_code);
        $this->assertEquals('hi', $result);
        $this->assertEquals('array', gettype($output));
        $this->assertEquals('abc', $output[0]);
        $this->assertEquals('hi', $output[1]);
    }

    public function testUnknownCommand()
    {
        $result = $this->runExec('aoebuaoeu', $output, $return_code);
        $this->assertEquals(127, $return_code);
        $this->assertEquals('', $result);
    }

    /*
    // test wait script (only locally available...)
    public function testWaitScript()
    {
        $result = $this->runExec('wait.sh 0.1 0', $output, $return_code);
        $this->assertEquals(0, $return_code, 'wait.sh command did not return with exit code 0');
        $this->assertEquals('Sleep for 0.1 seconds', $output[0]);
        $this->assertEquals('OK', $output[1]);
    }

    // test wait script (only locally available...)
    public function testWaitScriptReturnCode2()
    {
        $result = $this->runExec('wait.sh 0.1 2', $output, $return_code);
        $this->assertEquals(2, $return_code, 'wait.sh command did not return with exit code 2');
        $this->assertEquals('NOT OK', $output[1]);
    }

    public function testWaitScriptLongWait()
    {
        $result = $this->runExec('wait.sh 5 0', $output, $return_code);
        $this->assertEquals(0, $return_code, 'wait.sh command did not return with exit code 0');
        $this->assertEquals('OK', $output[1]);
    }
*/
/*
    public function all()
    {
        $this->devNull($className);
        $this->noReturnCodeSupplied($className);
        $this->noOutputSupplied($className);
    }
*/
}
