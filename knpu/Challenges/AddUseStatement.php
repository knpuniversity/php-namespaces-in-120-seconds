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

class AddUseStatement implements CodingChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
Next, see if you can add a `use` statement
to `eat.php` for the `Pizza` class. Then, you
can shorten the line that creates the new `Pizza`.
EOF;

    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
            ->addFileContents('eat.php', <<<EOF
<?php

require 'Pizza.php';

\$pizza = new \Food\Tasty\Pizza();

echo \$pizza->eat();
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
        $phpGrader->assertInputDoesNotContain('eat.php', 'use \Food\Tasty\Pizza', 'Don\'t use `\\` at the beginning of namespace in `use` statement. It doesn\'t necessary.');
        $phpGrader->assertInputContains('eat.php', 'use Food\Tasty\Pizza', 'You should to add a `use` statement for the `Pizza` class.');
        $phpGrader->assertInputDoesNotContain('eat.php', 'new \Food\Tasty\Pizza', 'You don\'t need to use a full namespace anymore when create an instance of `Pizza` class.');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('eat.php', <<<EOF
<?php

require 'Pizza.php';

use Food\Tasty\Pizza;

\$pizza = new Pizza();

echo \$pizza->eat();
EOF
            )
        ;
    }
}
