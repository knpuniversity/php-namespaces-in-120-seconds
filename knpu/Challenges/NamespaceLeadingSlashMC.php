<?php

namespace Challenges;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class NamespaceLeadingSlashMC implements MultipleChoiceChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Check out this `Koala` class:

```php
namespace Animal\Adorable;

class Koala
{
}
```

And this code that uses it:

```php
\$koala = new \Animal\Adorable\Koala();
```

Is that first slash in `\Animal\Adorable\Koala` necessary?
EOF;
    }

    /**
     * @param AnswerBuilder $builder
     */
    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder
            ->addAnswer(<<<EOF
Yes. If you choose to not have a `use` statement,
then you must always start with a `\` so that PHP knows
to build the namespace from the *root* of all namespaces.
EOF
            )
            ->addAnswer(<<<EOF
No. The slash is always optional, and really redundant:
PHP knows that you are looking for a class from the root of
the namespace.
EOF
            )
            ->addAnswer(<<<EOF
It depends on whether or not this file lives in a namespace.
EOF
            , true)
        ;
    }

    /**
     * @return string
     */
    public function getExplanation()
    {
        return <<<EOF
With no opening slash, PHP thinks you are referring to a
class that is in the current file's namespace *plus* this
namespace. For example:

```php
// namespaced_file.php
namespace Zoo;

\$koala = new Animal\Adorable\Koala();
// "Class not found Zoo\Animal\Adorable\Koala"
```php
// no_namespace.php
\$koala = new \Animal\Adorable\Koala();
// This works!
```

Most of the time you should have a `use` statement anyways,
But if you use the full namespace, it's much safer to
include the opening slash: that will *always* work.
EOF;
    }
}
