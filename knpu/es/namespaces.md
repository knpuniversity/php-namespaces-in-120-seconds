¡Tengo una idea! Dominemos los espacios de nombres de PHP... y hagámoslo en menos de 5 minutos.
Toma un poco de café... ¡vamos!

## Conoce a Foo

Conoce `Foo`: una clase de PHP perfectamente aburrida:

[[[ code('b56fd29496') ]]]

¡Saluda a `Foo`! Divertidísimo.

[[[ code('7ecd73b370') ]]]

Para instanciar nuestra nueva clase favorita, pasaré a otro archivo y diré
redoble de tambores - `$foo = new Foo()`:

[[[ code('f9ed47a6db') ]]]

¡Tada! Incluso podemos llamar a un método en él: `$foo->doAwesomeThings()`:

[[[ code('dbf77bb076') ]]]

¿Funcionará? Por supuesto Puedo abrir un terminal y ejecutar

```terminal
php some-other-file.php
```

## Namespaces: Haciendo a Foo más Hipster

Ahora mismo, `Foo` no tiene un espacio de nombres Para que `Foo` sea más hipster, vamos a arreglar
eso. Sobre la clase, añade, qué tal, `namespace Acme\Tools`:

[[[ code('608e841438') ]]]

Normalmente el espacio de nombres de una clase coincide con su directorio, pero eso no es técnicamente 
necesario. ¡Esto lo acabo de inventar yo!

## Utilizar una clase con espacio de nombres

¡Enhorabuena! Nuestro amigo `Foo` vive ahora en un espacio de nombres. Poner una clase en
un espacio de nombres es muy parecido a poner un archivo en un directorio. Para hacer referencia a ella, utiliza la
ruta completa y larga a la clase: `Acme\Tools\Foo`:

[[[ code('58dcb34f4d') ]]]

al igual que puedes utilizar la ruta absoluta para referenciar un archivo en tu sistema de archivos:

```terminal-silent
ls /acme/tools/foo
```

Cuando probemos el script ahora

```terminal-silent
php some-other-file.php
```

¡Sigue funcionando!

## La declaración de uso mágico y opcional

Y... ¡eso es realmente! Los espacios de nombres son básicamente una forma de... hacer que los nombres de tus clases
¡más largos! Añade el espacio de nombres... y luego haz referencia a la clase utilizando el espacio de nombres más
el nombre de la clase. Eso es todo.

Pero... ¡tener estos largos nombres de clase justo en medio de tu código es un fastidio!
Para solucionarlo, los espacios de nombres de PHP tienen otra cosa especial: la declaración `use`.
Al principio del archivo, añade `use Acme\Tools\Foo as SomeFooClass`:

[[[ code('78c677c9e4') ]]]

Esto crea una especie de... "acceso directo". En cualquier otro lugar de este archivo, ahora podemos
escribir simplemente `SomeClassFoo`:

[[[ code('89e80f5582') ]]]

y PHP sabrá que realmente nos estamos refiriendo al nombre largo de la clase: `Acme\Tools\Foo`.

```terminal-silent
php some-other-file.php
```

O... si omites la parte `as`, PHP asumirá que quieres que este alias sea
`Foo`. Así es como suele quedar el código:

[[[ code('355c2b033f') ]]]

Así, los espacios de nombres hacen que los nombres de las clases sean más largos... y las declaraciones `use` nos permiten crear
atajos para poder utilizar el nombre "corto" en nuestro código.

## Clases básicas de PHP

En el código PHP moderno, casi todas las clases con las que trates vivirán en un espacio de nombres...
excepto las clases principales de PHP. Sí, las clases principales de PHP no viven en un espacio de nombres...
lo que significa que viven en el espacio de nombres "raíz" - como un archivo en la raíz
de tu sistema de archivos:

```terminal-silent
ls /some-root-file
```

Juguemos con el objeto central de `DateTime`: `$dt = new DateTime()` y luego
`echo $dt->getTimestamp()` con un salto de línea:

[[[ code('a5fc3d8462') ]]]

Cuando ejecutamos el script

```terminal-silent
php some-other-file.php
```

¡Funciona perfectamente! Pero... ahora mueve ese mismo código al método `doAwsomeThings`
dentro de nuestro amigo `Foo`:

[[[ code('925adf8718') ]]]

Ahora prueba el código:

```terminal-silent
php some-other-file.php
```

¡Ah! ¡Explota! ¡Y comprueba el error!

> Clase `Acme\Tools\DateTime` no encontrada

El nombre real de la clase debería ser simplemente `DateTime`. Entonces, ¿por qué PHP cree que es
`Acme\Tools\DateTime`? Porque los espacios de nombres funcionan como directorios! `Foo` vive
en `Acme\Tools`. Cuando decimos simplemente `DateTime`, es lo mismo que buscar un
`DateTime` archivo dentro de un directorio `Acme/Tools`:

```terminal-silent
cd /acme/tools
ls DateTime    # /acme/tools/DateTime
```

Hay dos maneras de solucionar esto. La primera es utilizar el nombre de clase "completamente cualificado
nombre de la clase. Así, `\DateTime` 

[[[ code('3023b8d513') ]]]

Sí... eso funciona igual que un sistema de archivos.

```terminal-silent
php some-other-file.php
```

O... puedes utilizar `DateTime`... y luego eliminar el `\` de abajo 

[[[ code('2150351e16') ]]]

En realidad es lo mismo: no hay `\` al principio de una declaración `use`, 
pero debes fingir que lo hay. Esto hace que `DateTime` pase a ser `\DateTime`.

Y... ¡hemos terminado! Los espacios de nombres hacen que los nombres de tus clases sean más largos, las declaraciones de uso te permiten
crear "atajos" para que puedas utilizar nombres cortos en tu código y todo el
sistema funciona exactamente igual que los archivos dentro de los directorios.

¡Diviértete!
