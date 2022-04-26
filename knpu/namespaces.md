# PHP Namespaces in under 5 Minutes

I've an idea! Let's *master* PHP namespaces... and let's do it in *under* 5 minutes.
Sip some coffee... let's go!

## Meet Foo

Meet `Foo`: a *perfectly* boring PHP class:

[[[ code('b56fd29496') ]]]

Say hi `Foo`! Hilarious.

[[[ code('7ecd73b370') ]]]

To instantiate our favorite new class, I'll move over to a different file and say -
drumroll - `$foo = new Foo()`:

[[[ code('f9ed47a6db') ]]]

Tada! We can even call a method on it: `$foo->doAwesomeThings()`:

[[[ code('dbf77bb076') ]]]

Will it work? Of course! I can open a terminal and run:

```terminal
php some-other-file.php
```

## Namespaces: Making Foo more Hipster

Right now, `Foo` doesn't have a namespace! To make `Foo` more hipster, let's fix
that. Above the class, add, how about, `namespace Acme\Tools`:

[[[ code('608e841438') ]]]

Usually the namespace of a class matches its directory, but that's not *technically* 
required. I just invented this one!

## Using a Namespaced Class

Congratulations! Our friend `Foo` now lives in a namespace. Putting a class in
a namespace is a lot like putting a file in a directory. To reference it, use the
full, long path to the class: `Acme\Tools\Foo`:

[[[ code('58dcb34f4d') ]]]

just like you can use the absolute path to reference a file in your filesystem:

```terminal-silent
ls /acme/tools/foo
```

When we try the script now:

```terminal-silent
php some-other-file.php
```

It still works!

## The Magical & Optional use Statement

And... that's really! Namespaces are basically a way to... make your class names
longer! Add the namespace... then refer to the class using the namespace *plus*
the class name. That's it.

But... having these *long* class names right in the middle of your code is a bummer!
To fix that, PHP namespaces have *one* more special thing: the `use` statement.
At the top of the file, add `use Acme\Tools\Foo as SomeFooClass`:

[[[ code('78c677c9e4') ]]]

This creates a... sort of... "shortcut". Anywhere else in this file, we can now
just type `SomeClassFoo`:

[[[ code('89e80f5582') ]]]

and PHP will know that we're *really* referring to the long class name: `Acme\Tools\Foo`.

```terminal-silent
php some-other-file.php
```

Or... if you leave off the `as` part, PHP will assume you want this alias to be
`Foo`. That's usually how code looks:

[[[ code('355c2b033f') ]]]

So, namespaces make class names longer... and `use` statements allow us to create
shortcuts so we can use the "short" name in our code.

## Core PHP Classes

In modern PHP code, pretty much *all* classes you deal with will live in a namespace...
except for *core* PHP classes. Yep, core PHP classes do *not* live in a namespace...
which kinda means that they live at the "root" namespace - like a file at the root
of your filesystem:

```terminal-silent
ls /some-root-file
```

Let's play with the core `DateTime` object: `$dt = new DateTime()` and then
`echo $dt->getTimestamp()` with a line break:

[[[ code('a5fc3d8462') ]]]

When we run the script:

```terminal-silent
php some-other-file.php
```

It works perfectly! But... now move that *same* code into the `doAwsomeThings`
method inside our friend `Foo`:

[[[ code('925adf8718') ]]]

*Now* try the code:

```terminal-silent
php some-other-file.php
```

Ah! It explodes! And check out that error!

> Class `Acme\Tools\DateTime` not found

The *real* class name should just be `DateTime`. So, why does PHP think it's
`Acme\Tools\DateTime`? Because namespaces work like directories! `Foo` lives
in `Acme\Tools`. When we just say `DateTime`, it's the same as looking for a
`DateTime` file inside of an `Acme/Tools` directory:

```terminal-silent
cd /acme/tools
ls DateTime    # /acme/tools/DateTime
```

There are two ways to fix this. The first is to use the "fully qualified" class
name. So, `\DateTime`: 

[[[ code('3023b8d513') ]]]

Yep... that works *just* like a filesystem.

```terminal-silent
php some-other-file.php
```

*Or*... you can *use* `DateTime`... then remove the `\` below: 

[[[ code('2150351e16') ]]]

That's really the same thing: there's no `\` at the beginning of a `use` statement, 
but you should pretend there is. This aliases `DateTime` to `\DateTime`.

And... we're done! Namespaces make your class names longer, use statements allow
you to create "shortcuts" so you can use short names in your code and the *whole*
system works *exactly* like files inside directories.

Have fun! 
