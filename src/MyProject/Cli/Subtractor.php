<?php

namespace MyProject\Cli;

use MyProject\Controllers\AbstractController;
use MyProject\Exceptions\CliException;

class Subtractor extends AbstractCommand
{
    protected function checkParams()
    {
        $this->ensureParamExists('x');
        $this->ensureParamExists('y');
    }

    public function execute()
    {
        echo $this->getParam('x') - $this->getParam('y') . "\n";
    }
}