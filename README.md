Tag Replacer
============

This replacer replaces tags and add logic to strings.

Features
--------

### Tags

Tags are special tags embraced in `{{` and `}}`.
They have a name and may have arguments concatenated by `::` and parameters as query string.

#### Example

```
{{tag::argument1::argument2?param1=value1&param2=value2}}
```

#### Usage

```php
$replacer->registerTag('tag', function($name, $args, $params) {
	// $name   => 'tag'
	// $args   => array('argument1', 'argument2')
	// $params => array('param1' => 'value1, 'param2' => 'value2');
});
```

### Blocks

Blocks are special tags with a start and an end. They do something to the content they embrace.

**Hint:** You can register a block **and** a tag with the same name, but blocks are preferred before tags!

#### Example

```
{{myblock::argument1::argument2?param1=value1&param2=value2}}
Hello World
{{endmyblock}}
```

#### Usage

```php
$replacer->registerBlock('myblock', function($name, $args, $params, $body) {
	// $name   => 'myblock'
	// $args   => array('argument1', 'argument2')
	// $params => array('param1' => 'value1, 'param2' => 'value2');
	// $body   => "\nHello World\n"
});
```

### Recursive tags

Recursive tags are tags inside of other tags or blocks.

#### Example

```
{{tag1::{{tag2}}}}
```

### Tokens

Tokens do not have own logic as tags have. They are simple key=>value pairs.
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
{{tag|myfilter}}
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
	// $value => the result of {{tag}}, {{block}}...{{endblock}} or ##token##
});
```

Handling unknown tokens
-----------------------

By default, the Replacer will throw exceptions, but this behavior can be changed, there are three modes.
The handling can be defined for tags and tokens or separately.

```php
// trigger an error and leave empty
$replacer->setUnknownDefaultMode(TagReplacer::MODE_ERROR);

// trigger a warning and leave empty
$replacer->setUnknownTagMode(TagReplacer::MODE_WARNING);

// trigger a notice and leave empty
$replacer->setUnknownTokenMode(TagReplacer::MODE_NOTICE);
```

With `TagReplacer::MODE_EMPTY` an unknown tag/token will replaced with an empty value.
With `TagReplacer::MODE_SKIP` an unknown tag/token will not replaced.
Both can be used with or without `TagReplacer::MODE_ERROR`, `TagReplacer::MODE_WARNING` or `TagReplacer::MODE_NOTICE`.

```php
// trigger an error, but leave the tag as it is
$replacer->setUnknownDefaultMode(TagReplacer::MODE_ERROR | TagReplacer::MODE_SKIP);

// leave the tag as it is, but do not trigger an error
$replacer->setUnknownDefaultMode(TagReplacer::MODE_SKIP);

// leave empty and do not trigger an error
$replacer->setUnknownDefaultMode(TagReplacer::MODE_EMPTY);

```

Caching
-------

Insert Tags can be cached. Just use one of the doctrine cache implementations.
The cache only affects insert tags, no blocks or tokens.

```php
$replacer->setCache(new \Doctrine\Common\Cache\ArrayCache());
```
