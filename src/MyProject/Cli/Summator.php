<?php

namespace MyProject\Cli;

use MyProject\Controllers\AbstractController;
use MyProject\Exceptions\CliException;

class Summator extends AbstractCommand
{
    protected function checkParams()
    {
        $this->ensureParamExists('a');
        $this->ensureParamExists('b');
    }

    public function execute()
    {
        echo $this->getParam('a') + $this->getParam('b') . "\n";
    }
}
