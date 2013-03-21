<?php

namespace Bit3\InsertTagReplacer;

use Doctrine\Common\Cache\Cache;

/**
 * Class NoOpCache
 *
 * No operation cache.
 *
 * @package Bit3\InsertTagReplacer
 */
class NoOpCache implements Cache
{
	function fetch($id)
	{
		return false;
	}

	function contains($id)
	{
		return false;
	}

	function save($id, $data, $lifeTime = 0)
	{
		return true;
	}

	function delete($id)
	{
		return true;
	}

	function getStats()
	{
		return null;
	}

}