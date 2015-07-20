<?php
namespace DasRed\Parser\Exception;

use DasRed\Parser\Exception;

class RegexIsNotDefined extends Exception
{

	/**
	 *
	 * @param int $index
	 */
	public function __construct($index)
	{
		parent::__construct('The array key "regex" is not defined at index "' . $index . '"!');
	}
}
