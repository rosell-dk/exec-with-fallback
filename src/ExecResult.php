<?php
namespace Exec;


/**
 * The result of an execution
 *
 * @package    Exec
 * @author     Bjørn Rosell <it@rosell.dk>
 */
class ExecResult
{

    /**
     * @var array
     */
    protected $output;

    /**
     * @var int
     */
    protected $returnCode;

    /**
     * Create a new ExecResult object
     *
     * @param string $command  The command to execute
     *
     * @return \Exec\ExecResult The result
     */
    public function __construct($output, $returnCode)
    {
        $this->output = $output;
        $this->returnCode = $returnCode;
    }

    /**
     * Get the output (StdOut)
     *
     * @return array Array of strings
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Get the return code
     *
     * @return int
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

}
