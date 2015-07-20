<?php
namespace DasRedTest\Parser\Exception;

use DasRed\Parser\Exception;
use DasRed\Parser\Exception\EntryIsNotAnArray;

/**
 * @coversDefaultClass \DasRed\Parser\Exception\EntryIsNotAnArray
 */
class EntryIsNotAnArrayTest extends \PHPUnit_Framework_TestCase
{

	public function testExtends()
	{
		$exception = new EntryIsNotAnArray(0);
		$this->assertTrue($exception instanceof Exception);
	}

	public function dataProviderConstruct()
	{
		return [
			[1, 'The entry at index "1" is not an array!'],
			[-1, 'The entry at index "-1" is not an array!'],
			[0, 'The entry at index "0" is not an array!'],
			['nuff', 'The entry at index "nuff" is not an array!'],
		];
	}

	/**
	 * @param int $index
	 * @param string $message
	 * @covers ::__construct
	 * @dataProvider dataProviderConstruct
	 */
	public function testConstruct($index, $message)
	{
		$exception = new EntryIsNotAnArray($index);

		$this->assertEquals($message, $exception->getMessage());
	}
}