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
        $stack = ['exec', 'proc_open', 'passthru', 'shell_exec'];
        foreach ($stack as $method) {
            if (function_exists($method)) {
                if (func_num_args() == 3) {
                    $result = self::runExec($method, $command, $output, $result_code);
                } else {
                    $result = self::runExec($method, $command, $output);
                }
                if ($result !== false) {
                    return $result;
                }
            }
        }
        if ($result === false) {
            return false;
        }

        return exec($command, $output, $result_code);
    }

    public static function runExec($method, $command, &$output = null, &$result_code = null)
    {
        switch ($method) {
            case 'exec':
                return exec($command, $output, $result_code);
            case 'passthru':
                return Passthru::exec($command, $output, $result_code);
            case 'proc_open':
                return ProcOpen::exec($command, $output, $result_code);
            case 'shell_exec':
                if (func_num_args() == 4) {
                    return ShellExec::exec($command, $output, $result_code);
                } else {
                    return ShellExec::exec($command, $output);
                }
        }
        return false;
    }
}
