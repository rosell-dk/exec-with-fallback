<?php
namespace Tests\Exec;

use Exec\Exec;
use Exec\ExecException;
use PHPUnit\Framework\TestCase;

class ExecTest extends TestCase
{
    public function testBasic()
    {
        $result = Exec::execute('echo "hello"');
        $this->assertEquals(0, $result->getReturnCode());

        //2>&1
        // https://www.brianstorti.com/understanding-shell-script-idiom-redirect/

    }


    public function testSingle()
    {
        $result = Exec::executeUsing('echo "hello"', 'proc_open');
        $this->assertEquals(0, $result->getReturnCode());
    }


    // This should result in exception
    public function testNoExecutors()
    {
        $this->expectException(ExecException::class);
        $result = Exec::executeUsingFirstAvailable('echo "hello"', []);
    }

    public function testAssumptionAboutExec()
    {
        $output = [];
        $returnCode;
        $execResult = exec('ls 1>/dev/null', $output, $returnCode);
        $this->assertEquals(0, $returnCode);
        $this->assertEquals(0, count($output));
        $this->assertEquals('', $execResult);
    }

    public function testAssumptionAboutExec2()
    {
        $output = [];
        $returnCode;
        $execResult = exec('aoeuaoeu', $output, $returnCode);
        $this->assertEquals(127, $returnCode);
        //$this->assertEquals(0, count($output));
        $this->assertEquals('', $execResult);
    }

    public function testExec1()
    {
        $output = [];
        $returnCode;
        $execResult = Exec::exec('ls 1>/dev/null', $output, $returnCode);
        $this->assertEquals(0, $returnCode);
        $this->assertEquals(0, count($output));
        $this->assertEquals('', $execResult);
    }

    public function testExec2()
    {
        $output = [];
        $returnCode;
        $execResult = Exec::exec('aoeuaoeu', $output, $returnCode);
        $this->assertEquals(127, $returnCode);
        //$this->assertEquals(0, count($output));
        $this->assertEquals('', $execResult);
    }

}
