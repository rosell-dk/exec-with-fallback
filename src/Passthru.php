<?php

namespace ExecWithFallback;

/**
 * ProcOpenExecutor
 *
 * @package    Exec
 * @author     Bjørn Rosell <it@rosell.dk>
 */
class Passthru
{

  /**
   * Emulate exec() with passthru
   *
   * @param string $command  The command to execute
   * @param string &$output (optional)
   * @param int &$result_code (optional)
   *
   * @return string | false   The last line of output or false in case of failure
   */
    public static function exec($command, &$output = null, &$result_code = null)
    {
        ob_start();
        passthru($command, $result_code);
        $result = ob_get_clean();

        //$theOutput = preg_split("/[\n\r]+/", trim($result));
        $theOutput = explode(PHP_EOL, trim($result));
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
