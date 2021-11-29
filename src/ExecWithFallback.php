<?php
namespace ExecWithFallback;

/**
 * Execute command with exec(), open_proc() or whatever available
 *
 * @package    Exec
 * @author     Bjørn Rosell <it@rosell.dk>
 */
class ExecWithFallback
{

    /**
     * Execute. - A substitute for exec()
     *
     * Same signature and results as exec(): https://www.php.net/manual/en/function.exec.php
     *
     * @param string $command  The command to execute
     * @param string &$output (optional)
     * @param int &$result_code (optional)
     *
     * @return string | false   The last line of output or false in case of failure
     */
    public static function exec($command, &$output = null, &$result_code = null)
    {
        if (function_exists('exec')) {
            return exec($command, $output, $result_code);
        } elseif (function_exists('proc_open')) {
            return ProcOpen::exec($command, $output, $result_code);
        }
        return exec($command, $output, $result_code);
    }
}
