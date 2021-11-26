# Exec

[![Build Status](https://img.shields.io/github/workflow/status/rosell-dk/exec/PHP?logo=GitHub&style=flat-square)](https://github.com/rosell-dk/exec/actions/workflows/php.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/rosell-dk/exec/blob/master/LICENSE)


Execute command with *exec()*, *open_proc()* or whatever available

If `exec()` is available, it simply uses that method. Otherwise:
If `open_proc()` is available, it uses that to mimic an exec call.

Usage:

```php
use Exec\Exec;
$result = Exec::exec('echo "hi"');
$result->getReturnCode(); // 0 if ok. It is an int
$result->getOutput();     // array of lines
```

To use a certain alternative to exec(), you can do this:
```php
$result = Exec::execUsing('echo "hi"', 'proc_open');
```
Currently supported executors: "proc_open" | "exec"

In case of failure due to unavailablity, an ExecException is thrown.
In case exec() or proc_open() throws, it is currently not catched (but I'm considering...)

The state of this project is currently a quick draft. It needs to be tested across platforms. And it is the plan to mimic exec() using more methods.

Also, I might deal with StdErr in another way..
And the timeout set in open_proc should probably be customizable
