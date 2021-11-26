<?php

namespace Exec\Executors;

use \Exec\ExecResult;

/**
 * ExecExecutor.
 *
 * @package    Exec
 * @author     Bjørn Rosell <it@rosell.dk>
 */
class ExecExecutor extends BaseExecutor
{

  /**
   * Execute
   *
   * @param string $command  The command to execute
   *
   * @return \Exec\ExecResult The result
   */
    public function exec($command)
    {
        $output = [];
        $returnCode;
        $lastLineOrFalse = exec($command, $output, $returnCode);

        $result = new ExecResult($output, $returnCode);
        if ($lastLineOrFalse === false) {
            $result->failure = true;
        }
        return $result;
    }

    /**
     * Check if the required library/function is available
     *
     * @return bool if the function is available
     */
    public function available()
    {
        return (function_exists('exec'));
    }
}
