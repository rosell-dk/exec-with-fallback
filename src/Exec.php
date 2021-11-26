<?php
namespace Exec;

use \Exec\Executors\ExecExecutor;
use \Exec\Executors\ProcOpenExecutor;

/**
 * Execute command with exec(), open_proc() or whatever available
 *
 * @package    Exec
 * @author     Bjørn Rosell <it@rosell.dk>
 */
class Exec
{
    public static function createExecutor($executorId)
    {
        switch ($executorId) {
            case 'exec':
                return new ExecExecutor();
            case 'proc_open':
                return new ProcOpenExecutor();
        }
        throw new ExecException('Unknown executor: ' . $executorId);
    }

    /**
     * Execute using certain executor
     *
     * @param string $command     The command to execute
     * @param string $executorId  The executor id. Ie "Exec" or "ProcOpen".
     *
     * @return \Exec\ExecResult   The result
     * @throws \Exec\ExecException  If executor is unavailable
     */
    public static function execUsing($command, $executorId)
    {
        $executor = self::createExecutor($executorId);
        if ($executor->available()) {
            return $executor->exec($command);
        }
        throw new ExecException('Cannot execute command using ' . $executorId . ', as it is unavailable.');
    }

    /**
     * Execute using certain executors
     *
     * @param string $command  The command to execute
     *
     * @return \Exec\ExecResult The result
     */
    public static function execUsingFirstAvailable($command, $executorIds)
    {
        foreach ($executorIds as $executorId) {
            try {
                return self::execUsing($command, $executorId);
            } catch (ExecException $e) {
                // ignore.
            }
        }
        throw new ExecException(
            'Cannot execute command. All these methods are unavailable: ' . implode(', ', $executorIds)
        );
    }

    /**
     * Execute
     *
     * @param string $command  The command to execute
     *
     * @return \Exec\ExecResult The result
     */
    public static function exec($command)
    {
        return self::execUsingFirstAvailable($command, ['exec', 'proc_open']);
    }
}
