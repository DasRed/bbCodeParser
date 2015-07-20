<?php
namespace DasRed\Parser\Exception;

use DasRed\Parser\Exception;

class ReplacementIsNotDefined extends Exception
{

	/**
	 *
	 * @param int $index
	 */
	public function __construct($index)
	{
		parent::__construct('The array key "replacement" is not defined at index "' . $index . '"!');
	}
}
