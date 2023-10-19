# Exec with fallback

[![Latest Stable Version](http://poser.pugx.org/rosell-dk/exec-with-fallback/v)](https://packagist.org/packages/rosell-dk/exec-with-fallback)
[![Minimum PHP Version](https://img.shields.io/packagist/php-v/rosell-dk/exec-with-fallback)](https://packagist.org/packages/rosell-dk/exec-with-fallback)
[![Build Status](https://img.shields.io/github/actions/workflow/status/rosell-dk/exec-with-fallback/ci.yml?branch=main&logo=GitHub&style=flat-square)](https://github.com/rosell-dk/exec-with-fallback/actions/workflows/ci.yml)
[![Coverage](https://img.shields.io/endpoint?url=https://little-b.it/exec-with-fallback/code-coverage/coverage-badge.json)](http://little-b.it/exec-with-fallback/code-coverage/coverage/index.html)
[![Software License](http://poser.pugx.org/rosell-dk/exec-with-fallback/license)](https://github.com/rosell-dk/exec-with-fallback/blob/master/LICENSE)
[![Daily Downloads](http://poser.pugx.org/rosell-dk/exec-with-fallback/d/daily)](https://packagist.org/packages/rosell-dk/exec-with-fallback)

Some shared hosts may have disabled *exec()*, but leaved *proc_open()*, *passthru()*, *popen()* or *shell_exec()* open. In case you want to easily fall back to emulating *exec()* with one of these, you have come to the right library.

This library can be useful if you a writing code that is meant to run on a broad spectrum of systems, as it makes your exec() call succeed on more of these systems.

## Usage:
Simply swap out your current *exec()* calls with *ExecWithFallback::exec()*. The signatures are exactly the same.

```php
use ExecWithFallback\ExecWithFallback;
$result = ExecWithFallback::exec('echo "hi"', $output, $result_code);
// $output (array) now holds the output
// $result_code (int) now holds the result code
// $return (string | false) is now false in case of failure or the last line of the output
```

Note that while the signatures are the same, errors are not exactly the same. There is a reason for that. On some systems, a real `exec()` call results in a FATAL error when the function has been disabled. That is: An error, that cannot be catched. You probably don't want to halt execution on some systems, but not on other. But if you do, use `ExecWithFallback::execNoMercy` instead of `ExecWithFallback::exec`. In case no emulations are available, it calls *exec()*, ensuring exact same error handling as normal *exec()*.

If you have `function_exists('exec')` in your code, you probably want to change them to `ExecWithFallback::anyAvailable()`

## Installing
`composer require rosell-dk/exec-with-fallback`

## Implementation
*ExecWithFallback::exec()* first checks if *exec()* is available and calls it, if it is. In case *exec* is unavailable (deactivated on server), or exec() returns false, it moves on to checking if *passthru()* is available and so on. The order is as follows:
- exec()
- passthru()
- popen()
- proc_open()
- shell_exec()

In case all functions are unavailable, a normal exception is thrown (class: Exception). This is more gentle behavior than real exec(), which on some systems throws FATAL error when the function is disabled. If you want exactly same errors, use `ExecWithFallback::execNoMercy` instead, which instead of throwing an exception calls *exec*, which will result in a throw (to support older PHP, you need to catch both Exception and Throwable. And note that you cannot catch on all systems, because some throws FATAL)

In case none succeeded, but at least one failed by returning false, false is returned. Again to mimic *exec()* behavior.

PS: As *shell_exec()* does not support *$result_code*, it will only be used when $result_code isn't supplied. *system()* is not implemented, as it cannot return the last line of output and there is no way to detect if your code relies on that.

If you for some reason want to run a specific exec() emulation, you can use the corresponding class directly, ie *ProcOpen::exec()*.

## Is it worth it?
Well, often these functions are often all enabled or all disabled. So on the majority of systems, it will not make a difference. But on the other hand: This library is easily installed, very lightweight and very well tested.

**easily installed**\
Install with composer (`composer require rosell-dk/exec-with-fallback`) and substitute your *exec()* calls.

**lightweight**\
The library is extremely lightweight. In case *exec()* is available, it is called immediately and only the main file is auto loaded. In case all are unavailable, it only costs a little loop, amounting to five *function_exists()* calls, and again, only the main file is auto loaded. In case *exec()* is unavailable, but one of the others are available, only that implementation is autoloaded, besides the main file.

**well tested**\
I made sure that the function behaves exactly like *exec()*, and wrote a lot of test cases. It is tested on ubuntu, windows, mac (all in several versions). It is tested in PHP 5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0, 8.1 and 8.2. It is tested in different combinations of disabled functions (ie "exec" disabled, "passthru" disabled, both "exec" and "passthru" disabled, etc). The giant test of these combinations is run before each release. In additional to this, nightly builds with future PHP versions are tested once a month, allowing me to be avare of potential problems early. Status: [![Giant test](https://img.shields.io/github/actions/workflow/status/rosell-dk/htaccess-capability-tester/release.yml?branch=master&logo=GitHub&style=flat-square&label=Giant%20test)](https://github.com/rosell-dk/htaccess-capability-tester/actions/workflows/release.yml) [![PHP 8.3 nightly](https://img.shields.io/github/actions/workflow/status/rosell-dk/htaccess-capability-tester/php83.yml?branch=master&logo=GitHub&style=flat-square&label=PHP%208.3%20nightly)](https://github.com/rosell-dk/htaccess-capability-tester/actions/workflows/php83.yml)
[![PHP 8.4 nightly](https://img.shields.io/github/actions/workflow/status/rosell-dk/htaccess-capability-tester/php84.yml?branch=master&logo=GitHub&style=flat-square&label=PHP%208.4%20nightly)](https://github.com/rosell-dk/htaccess-capability-tester/actions/workflows/php84.yml)

**going to be maintained**\
The library is usid in [webp-convert](https://github.com/rosell-dk/webp-convert) and [webp-express](https://wordpress.org/plugins/webp-express/), both of which are used in many projects. So it is widely used and any future problems are bound to be discovered. While I don't expect much need for maintenance for this project, it is going to be there, if needed.

**Con: risk of being recognized as malware**
There is a slight risk that a lazy malware creator uses this library for his malware. The risk is however very small, as the library isn't suitable for malware. First off, the library doesn't try *system()*, as that function does not return output and thus cannot be used to emulate *exec()*. A malware creator would desire to try all possible ways to get his malware executed. Secondly, malware creators probably don't use composer for their malware and would probably want a single function instead of having it spread over multiple files. Third, the library here use a lot of effort in getting the emulated functions to behave exactly as exec(). This concern is probably non-existant for malware creators, who probably cares more about the effect of running the malware. Lastly, a malware creator would want to write his own function instead of copying code found on the internet. Copying stuff would impose a chance that the code is used by another malware creator which increases the risk of anti malware software recognizing it as malware.

## Do you like what I do?
Perhaps you want to support my work, so I can continue doing it :)

- [Become a backer or sponsor on Patreon](https://www.patreon.com/rosell).
- [Buy me a Coffee](https://ko-fi.com/rosell)

Thanks!
