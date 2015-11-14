PHP Namespaces in 120 Seconds
=============================

Time to master PHP 5.3 namespaces! The good news is, namespaces are easy!

To prove it, we've challenged ourselves to explain them in 120 seconds.

Let's go!

Meet `Foo`. He's a PHP 5.2 class that does a lot of important things:

    // Foo.php
    class Foo
    {
        public function doAwesomeFooThings()
        {

        }
    }

`Foo`, say hi to the listener:

    class Foo
    {
        public function doAwesomeFooThings()
        {
            echo 'say Hi to the listeners';
        }
    }

Ok, so `Foo`'s humor is a bit old too.

Using `Foo` is easy - simply `new Foo()`:

    // use_foo.php

    require 'Foo.php';

    $foo = new Foo();

To keep up with the times, let's put `Foo` in a brand new PHP 5.3 namespace.
A namespace is like a directory and by adding `namespace`, `Foo` now lives in
`Acme\Tools`:

    // Foo.php

    namespace Acme\Tools;

    class Foo
    {
        public function doAwesomeFooThings()
        {

        }
    }

To use `Foo`, we have to call him by his fancy new name:

    $foo = new \Acme\Tools\Foo();

This is just like referring to a file by its absolute path.

And that's really it! Adding a namespace to a class is like organizing files
from one directory, into a bunch of sub-directories. To refer to a class,
use its fully-qualified name, starting with the slash. From here, it's all
gravy.

Since running around with this giant name is a drag, let's add a shortcut:

    use Acme\Tools\Foo as SomeFooClass;

    $foo = new SomeFooClass();

The `use` statement lets us call `\Acme\Tools\Foo` class by a nickname.
Heck, we can call it anything, or just let it default to `Foo`:

    use \Acme\Tools\Foo;

    $foo = new Foo();

Great? But what about old-school, non-namespaced PHP classes? For that, let's
pick on `DateTime`, a handy class that's core to PHP, and got some new bells
and whistles in PHP 5.3. For ever and ever, creating a new `DateTime` object
looked the same: `new DateTime()`:

    // use_foo.php
    // ...

    $dt = new DateTime();

And if we're in a normal file, this still works. But in a namespaced file,
PHP thinks you're talking about a class *in* the `Acme\Tools` namespace:

    // Foo.php
    namespace Acme\Tools;

    class Foo
    {
        public function doAwesomeFooThings()
        {
            echo 'Hi listeners';

            // Wrong! PHP will incorrectly think we mean Acme\Tools\DateTime!
            $dt = new DateTime();
        }
    }

You can either refer to the class by its fully-qualified name - `\DateTime`:

    $dt = new \DateTime();

or add a `use` statement:

    // Foo.php
    namespace Acme\Tools;

    use \DateTime;

    class Foo
    {
        public function doAwesomeFooThings()
        {
            echo 'Hi listeners';

            // Yay!
            $dt = new DateTime();
        }
    }

Yes, the `use` statement looks silly, but it tells PHP that when you say
`DateTime`, you mean the non-namespaced class `DateTime`. Oh, and get rid of
the beginning slash with the `use` statement - everything works completely
the same with or without these, but you typically don't see them:

    use DateTime;

Ok bye!
