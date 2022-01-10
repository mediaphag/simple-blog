<?php

namespace MyProject\Cli;

use MyProject\Fixtures\ArticleFixtures;

class FixturesLoad extends AbstractCommand
{
    public function execute()
    {
        $articleQuantity = (int) $this->getParam('q');
        $articleFixtures = new ArticleFixtures();
        echo 'Generate articles' . PHP_EOL;
        $articleFixtures->load($articleQuantity);
        echo 'All done' . PHP_EOL;

    }

    protected function checkParams()
    {
        $this->ensureParamExists('q');
    }

}