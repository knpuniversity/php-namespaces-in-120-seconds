<?php

namespace Challenges;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class FixMissingUseStatement implements CodingChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
After lunch, the whole team is happily coding with
namespaces and `use` statements. Suddenly, someone
sees an error and calls you over for help! Can you
fix this code?

P.S. This is the *most* common mistake when using namespaces.
EOF;

    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
            ->addFileContents('Lunch.php', <<<EOF
<?php

namespace Meals;

class Lunch
{
    public function getFood()
    {
        return new Pizza();
    }
}
EOF
            )
            ->addFileContents('Pizza.php', <<<EOF
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
            , true)
            ->addFileContents('eat.php', <<<EOF
<?php

require 'Pizza.php';
require 'Lunch.php';

use Meals\Lunch;

\$lunch = new Lunch();
echo \$lunch->getFood()->eat();
EOF
            , true)
            ->setEntryPointFilename('eat.php')
        ;

        return $builder;
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

        $htmlGrader->assertOutputContains('COWP', 'The output no longer has the COWP! Is something wrong?');
        $phpGrader->assertInputContains(
            'Lunch.php',
            'return new Pizza',
            'Try to fix it without changing the `Pizza` class name in `getFood()` method.'
        );
        $phpGrader->assertInputDoesNotContain(
            'Lunch.php',
            'use \Food\Tasty\Pizza;',
            'Don\'t use `\\` at the beginning of namespace in `use` statement. It doesn\'t necessary.'
        );
        $phpGrader->assertInputContains(
            'Lunch.php',
            'use Food\Tasty\Pizza;',
            'Seems we need to add a `use` statement for the `Pizza` class in the `Lunch.php` file.'
        );
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('Lunch.php', <<<EOF
<?php

namespace Meals;

use Food\Tasty\Pizza;

class Lunch
{
    public function getFood()
    {
        return new Pizza();
    }
}
EOF
            )
        ;
    }
}
