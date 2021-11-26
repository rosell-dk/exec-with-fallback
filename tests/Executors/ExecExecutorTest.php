<?php
namespace Tests\Exec\Executors;

use Exec\Executors\ExecExecutor;
use PHPUnit\Framework\TestCase;

class ExecResultTest extends BaseTest
{

    public function testBasics()
    {
        $executor = new ExecExecutor();

        $this->runAllBasic($executor, 'Exec');

    }
}
