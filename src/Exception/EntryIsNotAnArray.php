<?php
namespace DasRed\Parser\Exception;

use DasRed\Parser\Exception;

class EntryIsNotAnArray extends Exception
{

	/**
	 *
	 * @param int $index
	 */
	public function __construct($index)
	{
		parent::__construct('The entry at index "' . $index . '" is not an array!');
	}
}
