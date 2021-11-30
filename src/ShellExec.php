<?php

namespace ExecWithFallback;

/**
 * Emulate exec() with system()
 *
 * @package    Exec
 * @author     Bjørn Rosell <it@rosell.dk>
 */
class ShellExec
{

  /**
   * Emulate exec() with system()
   *
   * @param string $command  The command to execute
   * @param string &$output (optional)
   * @param int &$result_code (optional)
   *
   * @return string | false   The last line of output or false in case of failure
   */
    public static function exec($command, &$output = null, &$result_code = null)
    {
      //echo "\NSHELL:" . $command . ':' . func_num_args() . "\n";

        $resultCodeSupplied = (func_num_args() >= 3);
        if ($resultCodeSupplied) {
            return false;
        }

        $result = shell_exec($command);

        $theOutput = preg_split('/\s*\r\n|\s*\n\r|\s*\n|\s*\r/', $result);

        // remove the last element if it is blank
        if ((count($theOutput) > 0) && ($theOutput[count($theOutput) -1] == '')) {
            array_pop($theOutput);
        }

        if (count($theOutput) == 0) {
            return '';
        }
        if (gettype($output) == 'array') {
            foreach ($theOutput as $line) {
                $output[] = $line;
            }
        } else {
            $output = $theOutput;
        }
        return $theOutput[count($theOutput) -1];
    }
}
