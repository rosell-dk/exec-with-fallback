<?php
namespace Tests\Exec;

use Exec\Exec;
use Exec\ExecException;
use PHPUnit\Framework\TestCase;

class ExecTest extends TestCase
{
    public function testBasic()
    {
        $result = Exec::exec('echo "hello"');
        $this->assertEquals(0, $result->getReturnCode());
    }


    public function testSingle()
    {
        $result = Exec::execUsing('echo "hello"', 'proc_open');
        $this->assertEquals(0, $result->getReturnCode());
    }


    // This should result in exception
    public function testNoExecutors()
    {
        $this->expectException(ExecException::class);
        $result = Exec::execUsingFirstAvailable('echo "hello"', []);
    }

}
