<?php
namespace DasRedTest\Parser\Exception;

use DasRed\Parser\Exception;
use DasRed\Parser\Exception\ReplacementIsNotDefined;

/**
 * @coversDefaultClass \DasRed\Parser\Exception\ReplacementIsNotDefined
 */
class ReplacementIsNotDefinedTest extends \PHPUnit_Framework_TestCase
{

	public function testExtends()
	{
		$exception = new ReplacementIsNotDefined(0);
		$this->assertTrue($exception instanceof Exception);
	}

	public function dataProviderConstruct()
	{
		return [
			[1, 'The array key "replacement" is not defined at index "1"!'],
			[-1, 'The array key "replacement" is not defined at index "-1"!'],
			[0, 'The array key "replacement" is not defined at index "0"!'],
			['nuff', 'The array key "replacement" is not defined at index "nuff"!'],
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
		$exception = new ReplacementIsNotDefined($index);

		$this->assertEquals($message, $exception->getMessage());
	}
}