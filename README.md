# Exec

[![Build Status](https://github.com/rosell-dk/exec-with-fallback/actions/workflows/php.yml/badge.svg)](https://github.com/rosell-dk/exec-with-fallback/actions/workflows/php.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/rosell-dk/exec-with-fallback/blob/master/LICENSE)

Simply swap out your current *exec()* calls with *ExecWithFallback::exec()* in order to get a more resilient exec(). In case *exec()* is unavailable, the library emulates it using one of the following functions: *open_proc()*, *passthru()*, *proc_open()*, *popen*, *shell_exec()*

The signatures are exactly the same as standard exec() and they handle errors the same way.

PS: As *shell_exec()* does not support $result_code, it will only be used when $result_code isn't supplied.

## Usage:
```php
use ExecWithFallback\ExecWithFallback;
$result = ExecWithFallback::exec('echo "hi"', $output, $result_code);
// $output (array) now holds the output
// $result_code (int) now holds the result code
// $return (string | false) is now false in case of failure or the last line of the output
```

## Current state: stable
It is now tested across many platforms and PHP versions. Not tested in PHP 5.6 yet, though.
