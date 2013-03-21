Contao Insert Tag Replacer
==========================

This Replacer replaces insert tags, but much more.
It is based on the [Twig Lexer](http://twig.sensiolabs.org/).

Features
--------

### Insert tags

Insert tags are special tags embraced in `{{` and `}}`.
They have a name and may have parameters, concatenated by `::`.

#### Example

```
{{itag::param1::param2}}
```

#### Usage

```php
$replacer->registerTag('itag', function($name, $args) {
	// $name => 'itag'
	// $args => array('param1', 'param2');
});
```

### Blocks

Blocks are special tags with a start and an end. They do something to the content they embrace.

**Hint:** You can register a block **and** a tag with the same name, but blocks are preferred before tags!

#### Example

```
{{myblock::param1::param2}}
Hello World
{{endmyblock}}
```

#### Usage

```php
$replacer->registerBlock('myblock', function($name, $args, $body) {
	// $name => 'myblock'
	// $args => array('param1', 'param2');
	// $body => "\nHello World\n"
});
```

### Recursive insert tags

Recursive insert tags are tag inside of other tags or blocks.

#### Example

```
{{tag1::{{tag2}}}}
```

### Simple tokens

Simple tokens do not have own logic as tags have. They are simple key=>value pairs.
To use in the content, embrace the name with `##`.

#### Example

```
##mytoken##
```

#### Usage

```php
$replacer->setToken('mytoken', 'myvalue');
```

### Filters for Tags, Blocks and Tokens

Filters manipulate the value of a tag, block or token.

#### Examples

```
{{itag|myfilter}}
```

```
{{block|myfilter}}
...
{{endblock}}
```

```
##token|myfilter##
```

#### Usage

```php
$replacer->registerFilter('myfilter', function($value) {
	// $value => the result of {{itag}}, {{block}}...{{endblock}} or ##token##
});
```

Handling unknown tokens
-----------------------

By default, the Replacer will throw exceptions, but this behavior can be changed, there are three modes.
The handling can be defined for tags and tokens or separately.

```php
// trigger an error and leave empty
$replacer->setUnknownDefaultMode(InsertTagReplacer::MODE_ERROR);

// trigger a warning and leave empty
$replacer->setUnknownTagMode(InsertTagReplacer::MODE_WARNING);

// trigger a notice and leave empty
$replacer->setUnknownTokenMode(InsertTagReplacer::MODE_NOTICE);
```

With `InsertTagReplacer::MODE_EMPTY` an unknown tag/token will replaced with an empty value.
With `InsertTagReplacer::MODE_SKIP` an unknown tag/token will not replaced.
Both can be used with or without `InsertTagReplacer::MODE_ERROR`, `InsertTagReplacer::MODE_WARNING` or `InsertTagReplacer::MODE_NOTICE`.

```php
// trigger an error, but leave the tag as it is
$replacer->setUnknownDefaultMode(InsertTagReplacer::MODE_ERROR | InsertTagReplacer::MODE_SKIP);

// leave the tag as it is, but do not trigger an error
$replacer->setUnknownDefaultMode(InsertTagReplacer::MODE_SKIP);

// leave empty and do not trigger an error
$replacer->setUnknownDefaultMode(InsertTagReplacer::MODE_EMPTY);

```