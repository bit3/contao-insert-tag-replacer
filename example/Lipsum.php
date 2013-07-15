<?php

include(__DIR__ . '/../vendor/autoload.php');

$ipsum = file_get_contents(__DIR__ . '/Lipsum.txt');

$replacer = new \Bit3\TagReplacer\TagReplacer();
$replacer->registerBlock(
	'uppercase',
	function ($name, $args, $params, $body) {
		return strtoupper($body);
	}
);
$replacer->registerTag(
	'ipsum',
	function ($name, $args, $params) {
		return 'Lorem ipsum';
	}
);
$replacer->registerTag(
	'praesent',
	function ($name, $args, $params) {
		array_unshift($args, $name);
		$args = array_map('ucfirst', $args);
		return implode(' ', $args);
	}
);
$replacer->registerTag(
	'echo',
	function ($name, $args, $params) {
		return implode(' ', $args);
	}
);
$replacer->registerTag(
	'dump',
	function ($name, $args, $params) {
		$buffer = array();
		ob_start();
		if (!empty($args)) {
			var_dump($args);
		}
		$buffer[] = trim(ob_get_clean());
		ob_start();
		if (!empty($params)) {
			var_dump($params);
		}
		$buffer[] = trim(ob_get_clean());
		return implode(' ', $buffer);
	}
);
$replacer->registerFilter('uppercase', 'strtoupper');
$replacer->setToken(
	'sed_condimentum_nibh',
	'Sed condimentum nibh'
);
$replacer->setToken(
	'ss',
	array(
		 'sed'         => 'Sed',
		 'suspendisse' => 'Suspendisse'
	)
);
echo $replacer->replace($ipsum);
