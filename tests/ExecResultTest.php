<?php
namespace Tests\Exec;

use Exec\ExecResult;
use PHPUnit\Framework\TestCase;

class ExecResultTest extends TestCase
{
    public function testBasic()
    {
        $output = ['hi'];
        $result = new ExecResult($output, 1);
        $this->assertSame($result->getReturnCode(), 1);
        $this->assertSame($result->getOutput()[0], 'hi');
    }

}
