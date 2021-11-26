<?php

namespace Exec\Executors;

use \Exec\ExecResult;

/**
 * ProcOpenExecutor
 *
 * @package    Exec
 * @author     Bjørn Rosell <it@rosell.dk>
 */
class ProcOpenExecutor extends BaseExecutor
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
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w"),
            //2 => array("file", "/tmp/error-output.txt", "a")
        );

        $cwd = getcwd(); // or is "/tmp" better?
        $processHandle = proc_open($command, $descriptorspec, $pipes, $cwd);
        $result = "";
        if (is_resource($processHandle)) {
            // Got this solution here:
            // https://stackoverflow.com/questions/5673740/php-or-apache-exec-popen-system-and-proc-open-commands-do-not-execute-any-com
            fclose($pipes[0]);
            $result = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            $returnCode = proc_close($processHandle);

            /*
            // This solution I got somewhere else. See the links in docs/todo.md
            // It seems the short one above works fine, though...

            $stdin = $pipes[0];
            $stdout = $pipes[1];
            $stderr = $pipes[2];

            stream_set_blocking($stdout, false);
            stream_set_blocking($stderr, false);

            $outEof = false;
            $errEof = false;

            do {
                $read = [ $stdout, $stderr ]; // [1]
                $write = null; // [1]
                $except = null; // [1]

                // [1] need to be as variables because only vars can be passed by reference

                stream_select(
                    $read,
                    $write,
                    $except,
                    1, // seconds
                    0); // microseconds

                $outEof = $outEof || feof($stdout);
                $errEof = $errEof || feof($stderr);

                if (!$outEof) {
                    $result .= fgets($stdout);
                }

                if (!$errEof) {
                    $result .= fgets($stderr);
                }
            } while(!$outEof || !$errEof);

            fclose($stdout);
            fclose($stderr);
            $returnCode = proc_close($processHandle);
            */

            $output = explode(PHP_EOL, trim($result));

            return new ExecResult($output, intval($returnCode));
        }
        throw new \Exception('proc_open() did not return resource');
    }

    /**
     * Check if the required library/function is available
     *
     * @return bool if the function is available
     */
    public function available()
    {
        return (function_exists('proc_open'));
    }
}
