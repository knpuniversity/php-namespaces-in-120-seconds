<?php

namespace Challenges;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class AddSimpleNamespace implements CodingChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
Everyone at the office is *starving*, but you want to
master namespaces before celebrating with lunch.

This `Pizza` class looks great. But now, give the
class a namespace - `Food\Tasty`. Then, update `eat.php`
to work, but **without** adding a `use` statement.

Everyone is starving, and depending on you!
EOF;

    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();
        $builder
            ->addFileContents('eat.php', <<<EOF
<?php
require 'Pizza.php';

\$pizza = new Pizza();

echo \$pizza->eat();
EOF
        )
            ->addFileContents('Pizza.php', <<<EOF
<?php

class Pizza
{
    public function eat()
    {
        return 'COWP!';
    }
}
EOF
        )
            ->setEntryPointFilename('eat.php');
    }

    public function getWorkerConfig(WorkerLoaderInterface $loader)
    {
        return $loader->load(__DIR__.'/php_worker.yml');
    }

    public function setupContext(CodingContext $context)
    {
    }

    public function grade(CodingExecutionResult $result)
    {
        $phpGrader = new PhpGradingTool($result);
        $htmlGrader = new HtmlOutputGradingTool($result);

        if (!class_exists('Food\Tasty\Pizza')) {
            if (class_exists('Pizza')) {
                throw new GradingException('Don\'t forget to give the `Pizza` class a namespace of `Food\Tasty`');
            } else {
                throw new GradingException('The `Pizza` class\'s `namespace` doesn\'t look right. Make sure it\'s `Food\Tasty`');
            }
        }

        $htmlGrader->assertOutputContains('COWP', 'The output no longer has the COWP! Is something wrong?');

        $phpGrader->assertInputDoesNotContain('eat.php', 'use', 'See if you can create a new `Pizza` class, but *without* a `use` statement');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('eat.php', <<<EOF
<?php
require 'Pizza.php';

\$pizza = new \Food\Tasty\Pizza();

echo \$pizza->eat();
EOF
        );

        $correctAnswer->setFileContents('Pizza.php', <<<EOF
<?php

namespace Food\Tasty;

class Pizza
{
    public function eat()
    {
        return 'COWP!';
    }
}
EOF
        );
    }
}
