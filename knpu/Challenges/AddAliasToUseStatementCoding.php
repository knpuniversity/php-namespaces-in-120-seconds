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

class AddAliasToUseStatementCoding implements CodingChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
The intern is messing around and has changed the `use`
statement of alias `Pizza` to `ItalianTreat`. Without
changing that line, update the `new` line so that the
code runs using the new alias.
EOF;

    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
            ->addFileContents('eat.php', <<<EOF
<?php

require 'Pizza.php';

use Food\Tasty\Pizza as ItalianTreat;

\$pizza = new Pizza();

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
        $phpGrader->assertInputContains(
            'eat.php',
            'use Food\Tasty\Pizza as ItalianTreat;',
            'Don\'t change a `use` line with the `ItalianTreat` alias. Update a line where creating new instance of the `Pizza` class instead.'
        );
        $phpGrader->assertInputContains(
            'eat.php',
            'new ItalianTreat',
            'Did you use the `ItalianTreat` alias for creating an instance of the `Pizza` class?'
        );
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('eat.php', <<<EOF
<?php

require 'Pizza.php';

use Food\Tasty\Pizza as ItalianTreat;

\$pizza = new ItalianTreat();

echo \$pizza->eat();
EOF
            )
        ;
    }
}
