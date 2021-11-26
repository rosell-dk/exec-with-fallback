<?php
namespace Tests\Exec\Executors;

use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    public function test0()
    {
        $this->assertEquals(0, 0);
    }

    public function runAllBasic($executor, $className)
    {

        $this->assertIsBool($executor->available());

        if ($executor->available()) {
            // test echo
            $result = $executor->exec('echo "hi"');
            $this->assertEquals(0, $result->getReturnCode(), 'calling echo "hi" did not return with returnCode 0');
            $this->assertEquals($result->getOutput()[0], 'hi', 'calling echo "hi" did not return ["hi"]');

            // test two lines
            $result = $executor->exec('echo "hi" && echo "world"');
            $this->assertEquals(0, $result->getReturnCode());
            $output = $result->getOutput();
            $this->assertEquals(count($output), 2, print_r($output, true));
            $this->assertEquals($result->getOutput()[0], 'hi');
            $this->assertEquals($result->getOutput()[1], 'world');

            // Redirect stderr to same place as stdout with "2>&1"
            // https://www.brianstorti.com/understanding-shell-script-idiom-redirect/
            //$command = ($useNice ? 'nice ' : '') . $binary . ' ' . $commandOptions . ' 2>&1';

            // test error
            $result = $executor->exec('aoeuaoeu 2>&1');
            $this->assertEquals(127, $result->getReturnCode(), 'calling rubbish command did not return with exit code 127');
            $output = $result->getOutput();

            // test wait script (only locally available...)
/*
            $result = $executor->exec('wait.sh 0.1 0');
            $this->assertEquals(0, $result->getReturnCode(), 'wait.sh command did not return with exit code 0');
            $output = $result->getOutput();
            $this->assertEquals('Sleep for 0.1 seconds', $result->getOutput()[0]);
            $this->assertEquals('OK', $result->getOutput()[1]);

            // test wait, exiting with return code 2
            $result = $executor->exec('wait.sh 0.1 2');
            $this->assertEquals(2, $result->getReturnCode(), 'wait.sh 0.1 2 command did not return with exit code 2');
            $output = $result->getOutput();
            $this->assertEquals('NOT OK', $result->getOutput()[1]);


            // test long wait
            $result = $executor->exec('wait.sh 10 0');
            $this->assertEquals(0, $result->getReturnCode(), 'wait.sh command did not return with exit code 0');
            $output = $result->getOutput();
            $this->assertEquals('Sleep for 10 seconds', $result->getOutput()[0]);
            $this->assertEquals('OK', $result->getOutput()[1]);
*/

            //print_r($output);
            /*$this->assertEquals(count($output), 2);
            $this->assertEquals($result->getOutput()[0], 'hi');
            $this->assertEquals($result->getOutput()[1], 'world');*/

        }

    }

}
