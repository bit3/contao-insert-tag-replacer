Contao Insert Tag Replacer
==========================

This Replacer replaces insert tags, but much more.
It is based on the [Twig Lexer](http://twig.sensiolabs.org/).

Features
--------

### Replaces insert tags

```
{{itag::param1::param2}}
```

#### Registration

```php
$replacer->registerTag('itag', function($name, $args) {
	// $name => 'itag'
	// $args => array('param1', 'param2');
});
```

### Allow recursive insert tags

```
{{tag1::{{tag2}}}}
```

### Blocks

```
{{myblock::param1::param2}}
Hello World
{{endmyblock}}
```

#### Registration

```php
$replacer->registerBlock('myblock', function($name, $args, $body) {
	// $name => 'myblock'
	// $args => array('param1', 'param2');
	// $body => "\nHello World\n"
});
```

**Hint:** You can register a block and a tag with the same name, but blocks are preferred!

### Filters for Tags and Blocks

```
{{itag|myfilter}}
```

```
{{block|myfilter}}
...
{{endblock}}
```

#### Registration

```php
$replacer->registerFilter('myfilter', function($value) {
	// $value => the result of {{itag}} or {{block}}...{{endblock}}
});
```
