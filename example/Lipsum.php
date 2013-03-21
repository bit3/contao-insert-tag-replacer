<?php

include(__DIR__ . '/../vendor/autoload.php');

$ipsum = file_get_contents(__DIR__ . '/Lipsum.txt');

$replacer = new \Bit3\InsertTagReplacer\InsertTagReplacer();
$replacer->registerBlock(
	'uppercase',
	function ($name, $args, $body) {
		return strtoupper($body);
	}
);
$replacer->registerTag(
	'ipsum',
	function ($name, $args) {
		return 'Lorem ipsum';
	}
);
$replacer->registerTag(
	'praesent',
	function ($name, $args) {
		array_unshift($args, $name);
		$args = array_map('ucfirst', $args);
		return implode(' ', $args);
	}
);
$replacer->registerTag(
	'echo',
	function ($name, $args) {
		return implode(' ', $args);
	}
);
$replacer->registerFilter('uppercase', 'strtoupper');
$replacer->setToken(
	'sed_condimentum_nibh',
	'Sed condimentum nibh'
);
echo $replacer->replace($ipsum);
