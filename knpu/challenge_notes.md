## Challenge 1
- AddSimpleNamespace - done!

## Challenge 2
Next, see if you can add a `use` statement
to `eat.php` for the `Pizza` class. Then, you
can shorten the line that creates the new `Pizza`.

## Challenge 3

Multiple Choice:

Check out this `Koala` class:

```php
namespace Animal\Adorable;

class Koala
{
}
```

And this code that uses it:

```php
$koala = new \Animal\Adorable\Koala();
```

Is that first slash (`\Animal`) necessary?

A) Yes. If you choose to not have a `use` statement,
then you must always start with a `\` so that PHP knows
to build the namespace from the *root* of all namespaces.

B) No. The slash is always optional, and really redundant:
PHP knows that you are looking for a class from the root of
the namespace.

C) It depends on whether or not this file lives in a
namespace.

Correct: C

Explanation:

With no opening slash, PHP thinks you are referring to a
class that is in the current file's namespace *plus* this
namespace. For example:

```php
namespace Zoo;
$koala = new Animal\Adorable\Koala();
// "Class not found Zoo\Animal\Adorable\Koala"
$koala = new \Animal\Adorable\Koala();
// This works!
```

Most of the time you should have a `use` statement anyways,
But if you use the full namespace, it's much safer to
include the opening slash: that will *always* work.

## Challenge 4

The intern is messing around and has changed the `use`
statement to alias `Pizza` to `ItalianTreat`. Without
changing that line, update the `new` line so that the
code runs using the new alias.

## Challenge 5

After lunch, the whole team is happily coding with
namespaces and `use` statements. Suddenly, someone
sees an error and calls you over for help! Can you
fix this code?

P.S. This is the *most* common mistake when using namespaces.

***FILES***

In this example, we will forget to add the use statement
for `Pizza` in the `Lunch` class. They will have to debug
that this `use` statement is missing.

--> Use the Food\Tasty\Pizza class again

***Lunch.php***

namespace Meals;

class Lunch
{
    public function getFood()
    {
        return new Pizza();
    }
}

***eat.php***

<?php
require 'Pizza.php';
require 'Lunch.php';

use Meals\Lunch;

$lunch = new Lunch();
echo $lunch->getFood()->eat();

