<?php

namespace Bit3\TagReplacer\Internals;

use Doctrine\Common\Cache\Cache;

class TokenTag
{
	/**
	 * @var TagReplacer
	 */
	protected $replacer;

	function __construct($replacer)
	{
		$this->replacer = $replacer;
	}

	public function replace($name)
	{
		return $this->replacer->evaluateToken($name);
	}
}
