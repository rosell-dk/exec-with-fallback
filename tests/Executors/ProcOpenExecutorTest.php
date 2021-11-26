<?php
namespace Tests\Exec\Executors;

use Exec\Executors\ProcOpenExecutor;
use PHPUnit\Framework\TestCase;

class ProcOpenExecutorTest extends BaseTest
{

    public function testBasics()
    {
        $executor = new ProcOpenExecutor();

        $this->runAllBasic($executor, 'ProcOpen');
    }

}
