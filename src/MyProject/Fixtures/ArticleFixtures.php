<?php

namespace MyProject\Fixtures;

use DavidBadura\FakerMarkdownGenerator\FakerProvider;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;

class ArticleFixtures
{
    public function load($articleQuantity)
    {
        $users = User::findAll();
        $faker = \Faker\Factory::create();
        $faker->addProvider(new FakerProvider($faker));

        for ($i = 0; $i < $articleQuantity; $i++) {
            $article = new Article();
            $article->setName($faker->sentence($faker->numberBetween(3, 9)));
            $article->setText($faker->markdown());
            $article->setAuthor($faker->randomElement($users));

            $article->save();
        }
    }
}