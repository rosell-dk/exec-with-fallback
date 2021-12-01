<?php
namespace ExecWithFallback;

/**
 * Check if any of the methods are available
 *
 * @package    ExecWithFallback
 * @author     Bjørn Rosell <it@rosell.dk>
 */
class Availability
{

    public static function anyAvailable($needResultCode = true)
    {
        foreach (ExecWithFallback::$methods as $method) {
            if (self::methodAvailable($method, $needResultCode)) {
                return true;
            }
        }
        return false;
    }

    public static function methodAvailable($method, $needResultCode = true)
    {
        if (!function_exists($method)) {
            return false;
        }
        if ($needResultCode) {
            return ($method != 'shell_exec');
        }
        return true;
    }
}
