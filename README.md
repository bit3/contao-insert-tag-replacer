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
###mytoken###
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
