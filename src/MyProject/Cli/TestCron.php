<?php

namespace MyProject\Cli;

class TestCron extends AbstractCommand
{

    public function execute()
    {
        // to check the script's work, we will write the current date and time to the file 1.log
        file_put_contents('/var/www/blog.ll/logs/1.logs', date(DATE_ISO8601) . PHP_EOL, FILE_APPEND);
    }

    protected function checkParams()
    {
        $this->ensureParamExists('x');
        $this->ensureParamExists('y');
    }
}