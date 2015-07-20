<?php
namespace DasRedTest\Parser\Exception;

use DasRed\Parser\Exception;
use DasRed\Parser\Exception\RegexIsNotDefined;

/**
 * @coversDefaultClass \DasRed\Parser\Exception\RegexIsNotDefined
 */
class RegexIsNotDefinedTest extends \PHPUnit_Framework_TestCase
{

	public function testExtends()
	{
		$exception = new RegexIsNotDefined(0);
		$this->assertTrue($exception instanceof Exception);
	}

	public function dataProviderConstruct()
	{
		return [
			[1, 'The array key "regex" is not defined at index "1"!'],
			[-1, 'The array key "regex" is not defined at index "-1"!'],
			[0, 'The array key "regex" is not defined at index "0"!'],
			['nuff', 'The array key "regex" is not defined at index "nuff"!'],
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
		$exception = new RegexIsNotDefined($index);

		$this->assertEquals($message, $exception->getMessage());
	}
}