# PHP Namespaces in 120 Seconds

Time to master PHP 5.3 namespaces! The good news is, namespaces are easy!

To prove it, we've challenged ourselves to explain them in 120 seconds.

Let's go!

Meet `Foo`. He's a PHP 5.2 class that does a lot of important things:

[[[ code('b56fd29496') ]]]

`Foo`, say hi to the listener:

[[[ code('521bce7fd3') ]]]

Ok, so `Foo`'s humor is a bit old too.

Using `Foo` is easy - simply `new Foo()`:

[[[ code('f9ed47a6db') ]]]

## Adding a namespace

To keep up with the times, let's put `Foo` in a brand new PHP 5.3 namespace.
A namespace is like a directory and by adding `namespace`, `Foo` now lives in
`Acme\Tools`:

[[[ code('32d4d7b16a') ]]]

To use `Foo`, we have to call him by his fancy new name:

[[[ code('4624257bf7') ]]]

This is just like referring to a file by its absolute path.

And that's really it! Adding a namespace to a class is like organizing files
from one directory, into a bunch of sub-directories. To refer to a class,
use its fully-qualified name, starting with the slash. From here, it's all
gravy.

## The use Statement

Since running around with this giant name is a drag, let's add a shortcut:

[[[ code('79b7e5476b') ]]]

The `use` statement lets us call `\Acme\Tools\Foo` class by a nickname.
Heck, we can call it anything, or just let it default to `Foo`:

[[[ code('7d74dbe49f') ]]]

## The non-namespaced DateTime Class

Great? But what about old-school, non-namespaced PHP classes? For that, let's
pick on `DateTime`, a handy class that's core to PHP, and got some new bells
and whistles in PHP 5.3. For ever and ever, creating a new `DateTime` object
looked the same: `new DateTime()`:

[[[ code('63511297b8') ]]]

And if we're in a normal file, this still works. But in a namespaced file,
PHP thinks you're talking about a class *in* the `Acme\Tools` namespace:

[[[ code('66383ae8de') ]]]

You can either refer to the class by its fully-qualified name - `\DateTime`:

[[[ code('727da4aabf') ]]]

or add a `use` statement:

[[[ code('aeb686bacd') ]]]

Yes, the `use` statement looks silly, but it tells PHP that when you say
`DateTime`, you mean the non-namespaced class `DateTime`. Oh, and get rid of
the beginning slash with the `use` statement - everything works completely
the same with or without these, but you typically don't see them:

[[[ code('dd56f98d18') ]]]

Ok bye!
