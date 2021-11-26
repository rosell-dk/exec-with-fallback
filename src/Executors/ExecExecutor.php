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
    public function exec($command) {
        exec($command, $output, $returnCode);
        return new ExecResult($output, intval($returnCode));
    }

    /**
     * Check if the required library/function is available
     *
     * @return \Exec\ExecResult The result
     */
    public function available() {
        return (function_exists('exec'));
    }

}
