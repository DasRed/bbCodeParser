<?php
namespace DasRedTest\Parser;
use DasRed\Parser\Exception;
/**
 * @coversDefaultClass \DasRed\Parser\Exception
 */
class ExceptionTest extends \PHPUnit_Framework_TestCase
{
	public function testExtends()
	{
		$exception = new Exception();
		$this->assertTrue($exception instanceof \Exception);
	}
}