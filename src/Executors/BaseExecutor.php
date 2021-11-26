<?php

namespace Exec\Executors;

/**
 * Base for all converter classes.
 *
 * @package    Exec
 * @author     Bjørn Rosell <it@rosell.dk>
 */
abstract class BaseExecutor
{

  /**
   * Execute
   *
   * @param string $command  The command to execute
   *
   * @return \Exec\ExecResult The result
   */
    abstract protected function exec($command);

    /**
     * Check if the required library/function is available
     *
     * @return bool if the function is available
     */
    abstract protected function available();
}
