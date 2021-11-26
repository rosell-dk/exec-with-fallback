# Exec

[![Build Status](https://img.shields.io/github/workflow/status/rosell-dk/exec/PHP?logo=GitHub&style=flat-square)](https://github.com/rosell-dk/exec/actions/workflows/php.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/rosell-dk/exec/blob/master/LICENSE)

Execute command with *exec()*, *open_proc()* or whatever available

If `exec()` is available, it simply uses that method. Otherwise:
If `open_proc()` is available, it uses that to mimic an exec call.

## Usage:

You can swap out your *exec()* calls with *Exec::exec()*. Or you can call `Exec::execute()`, which returns an object with the result, rather than using the more obscure syntax of PHP *exec()*

Here is an example, where we swap *exec()* calls with *Exec::exec()*.
```php
use Exec\Exec;
$output = [];
$result_code;
$result = Exec::exec('echo "hi"', $output, $result_code);
// $output (array) now holds the output
// $result_code (int) now holds the result code
// $return (string | false) is now false in case of failure or the last line of the output
```
In case of failure due to unavailablity, an ExecException is thrown. The rationale is that exec() throws it is not available and we want to mimic that behavior. ExecException is a subclass of Exception. I'm considering to throw another exception, which is subclass of Error for PHP 7 and above, again to mimic behavior, so your catch clauses works as usual.

Here is an example where we use `Exec:execute()` instead of `Exec:exec()` in order to get better code readability:

```php
use Exec\Exec;
$result = Exec::execute('echo "hi"');
$result->getReturnCode(); // 0 if ok. It is an int
$result->getOutput();     // array of lines
```
In case of failure due to unavailablity, an ExecException is thrown.
In case exec() or proc_open() throws, it is currently not catched (but I'm considering...)


To use a certain alternative to exec(), you can do this:
```php
$result = Exec::executeUsing('echo "hi"', 'proc_open');
```
Currently supported executors: "proc_open" | "exec"



## Background
Some hosts ([at least one](https://wordpress.org/support/topic/php-8-and-exec-disabled-leads-to-fatal-error/#post-15103963)) disallows *exec()*, but allows *open_proc()*. In case you have no control over the serve and want you code to run on as many hosts as possible, you can swap out your *exec()* calls with this library. At least, that is the aim. It is not there yet!


## Current state: drafty

The state of this project is currently a quick draft. It needs to be tested across platforms. And it is the plan to mimic exec() using more methods.

Also, I might deal with StdErr in another way..
And the timeout set in open_proc should probably be customizable
