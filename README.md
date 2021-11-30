# Exec with fallback

[![Latest Stable Version](http://poser.pugx.org/rosell-dk/exec-with-fallback/v)](https://packagist.org/packages/rosell-dk/exec-with-fallback)
[![Build Status](https://github.com/rosell-dk/exec-with-fallback/actions/workflows/php.yml/badge.svg)](https://github.com/rosell-dk/exec-with-fallback/actions/workflows/php.yml)
[![Software License](http://poser.pugx.org/rosell-dk/exec-with-fallback/license)](https://github.com/rosell-dk/exec-with-fallback/blob/master/LICENSE)
[![PHP Version Require](http://poser.pugx.org/rosell-dk/exec-with-fallback/require/php)](https://packagist.org/packages/rosell-dk/exec-with-fallback)


Some shared hosts may have disabled *exec()*, but leaved *proc_open()*, *passthru()*, *popen()* or *shell_exec()* open. In case you want to easily fall back to emulating *exec()* with one of these, you have come to the right library.

This library can be useful if you a writing code that is meant to run on a broad spectrum of systems, as it makes your exec() call succeed on more of these systems.

## Usage:
Simply swap out your current *exec()* calls with *ExecWithFallback::exec()*. The signatures are exactly the same and errors are handled the same way.

```php
use ExecWithFallback\ExecWithFallback;
$result = ExecWithFallback::exec('echo "hi"', $output, $result_code);
// $output (array) now holds the output
// $result_code (int) now holds the result code
// $return (string | false) is now false in case of failure or the last line of the output
```

## Implementation
*ExecWithFallback::exec()* first checks if *exec()* is available and calls it, if it is. In case *exec* is unavailable (deactivated on server), or exec() returns false, it moves on to checking if *passthru()* is available and so on. The order is as follows:
- exec()
- passthru()
- popen()
- proc_open()
- shell_exec()

In case all functions are unavailable, *exec()* is called. This ensures that the error handling will be exactly as usual. In case none succeeded, but at least one failed by returning false, false is returned. Again to mimic *exec()* behavior.

PS: As *shell_exec()* does not support *$result_code*, it will only be used when $result_code isn't supplied. *system()* is not implemented, as it cannot return the last line of output and there is no way to detect if your code relies on that.

If you for some reason want to run a specific exec() emulation, you can use the corresponding class directly, ie *ProcOpen::exec()*.
