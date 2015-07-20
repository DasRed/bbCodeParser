<?php
namespace DasRedTest\Parser;

use DasRed\Parser\BBCode;
use DasRed\Parser\Exception\EntryIsNotAnArray;
use DasRed\Parser\Exception\RegexIsNotDefined;
use DasRed\Parser\Exception\ReplacementIsNotDefined;

/**
 * @coversDefaultClass \DasRed\Parser\BBCode
 */
class BBCodeTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @covers ::__construct
	 */
	public function testConstructorWithConfigFile()
	{
		$bbcode = new BBCode(__DIR__ . '/files/constructor-1.ini');

		$reflectionMethodGetBbCodes = new \ReflectionMethod($bbcode, 'getBbCodes');
		$reflectionMethodGetBbCodes->setAccessible(true);
		$this->assertEquals([
			'#\[br\]#i' => '<br>',
			'#\[b\](.+)\[/b\]#isU' => '<strong>$1</strong>',
			'#\[i\](.+)\[/i\]#isU' => '<em>$1</em>'
		], $reflectionMethodGetBbCodes->invoke($bbcode));
	}

	/**
	 * @covers ::__construct
	 */
	public function testConstructorWithNull()
	{
		$bbcode = new BBCode(null);

		$reflectionMethodGetBbCodes = new \ReflectionMethod($bbcode, 'getBbCodes');
		$reflectionMethodGetBbCodes->setAccessible(true);
		$this->assertEquals([], $reflectionMethodGetBbCodes->invoke($bbcode));

	}

	/**
	 * @covers ::loadConfig
	 */
	public function testLoadConfigDefault()
	{
		$bbcode = new BBCode();

		$reflectionMethod = new \ReflectionMethod($bbcode, 'getBbCodes');
		$reflectionMethod->setAccessible(true);

		$this->assertEquals([
			'#\[br\]#i' => '<br>',
			'#\[b\](.+)\[/b\]#isU' => '<strong>$1</strong>',
			'#\[i\](.+)\[/i\]#isU' => '<em>$1</em>',
			'#\[u\](.+)\[/u\]#isU' => '<u>$1</u>',
			'#\[h1\](.+)\[/h1\]#isU' => '<h1><a href="#$1" name="$1">$1</a></h1>',
			'#\[h2\](.+)\[/h2\]#isU' => '<h2><a href="#$1" name="$1">$1</a></h2>',
			'#\[h3\](.+)\[/h3\]#isU' => '<h3><a href="#$1" name="$1">$1</a></h3>',
			'#\[h4\](.+)\[/h4\]#isU' => '<h4><a href="#$1" name="$1">$1</a></h4>',
			'#\[h5\](.+)\[/h5\]#isU' => '<h5><a href="#$1" name="$1">$1</a></h5>',
			'#\[h6\](.+)\[/h6\]#isU' => '<h6><a href="#$1" name="$1">$1</a></h6>',
			'#\[p\](.+)\[/p\]#isU' => '<p>$1</p>',
			'#\[color=(.+)\](.+)\[/color\]#isU' => '<span style="color:$1">$2</span>',
			'#\[size=([0-9]+)\](.+)\[/size\]#isU' => '<span style="font-size:$1px">$2</span>',
			'#\[img\](.+)\[/img\]#isU' => '<img src="$1">',
			'#\[img=(.+)\]#isU' => '<img src="$1">',
			'#\[email\](.+)\[/email\]#isU' => '<a href="mailto:$1">$1</a>',
			'#\[email=(.+)\](.+)\[/email\]#isU' => '<a href="mailto:$1">$2</a>',
			'#\[url\](.+)\[/url\]#isU' => '<a href="$1">$1</a>',
			'#\[url=(.+)\|onclick\](.+)\[/url\]#isU' => '<a onclick="$1">$2</a>',
			'#\[url=(.+)\starget=(.+)\](.+)\[/url\]#isU' => '<a href="$1" target="$2">$3</a>',
			'#\[url=(.+)\](.+)\[/url\]#isU' => '<a href="$1">$2</a>',
			'#\[a=(.+)\](.+)\[/a\]#isU' => '<a href="#$1" name="$1">$2</a>',
			'#\[list\](.+)\[/list\]#isU' => '<ul>$1</ul>',
			'#\[\*\](.+)\[/\*\]#isU' => '<li>$1</li>'
		], $reflectionMethod->invoke($bbcode));
	}

	/**
	 * @covers ::loadConfig
	 */
	public function testLoadConfigNormalIni()
	{
		$bbcode = new BBCode(null);

		$reflectionMethodLoadConfig = new \ReflectionMethod($bbcode, 'loadConfig');
		$reflectionMethodLoadConfig->setAccessible(true);
		$this->assertSame($bbcode, $reflectionMethodLoadConfig->invoke($bbcode, __DIR__ . '/files/constructor-1.ini'));

		$reflectionMethodGetBbCodes = new \ReflectionMethod($bbcode, 'getBbCodes');
		$reflectionMethodGetBbCodes->setAccessible(true);
		$this->assertEquals([
			'#\[br\]#i' => '<br>',
			'#\[b\](.+)\[/b\]#isU' => '<strong>$1</strong>',
			'#\[i\](.+)\[/i\]#isU' => '<em>$1</em>'
		], $reflectionMethodGetBbCodes->invoke($bbcode));
	}

	/**
	 * @covers ::loadConfig
	 */
	public function testLoadConfigNormalPhp()
	{
		$bbcode = new BBCode(null);

		$reflectionMethodLoadConfig = new \ReflectionMethod($bbcode, 'loadConfig');
		$reflectionMethodLoadConfig->setAccessible(true);
		$this->assertSame($bbcode, $reflectionMethodLoadConfig->invoke($bbcode, __DIR__ . '/files/constructor-4.php'));

		$reflectionMethodGetBbCodes = new \ReflectionMethod($bbcode, 'getBbCodes');
		$reflectionMethodGetBbCodes->setAccessible(true);
		$this->assertEquals([
			'#\[br\]#i' => '<br>',
			'#\[b\](.+)\[/b\]#isU' => '<strong>$1</strong>',
			'#\[i\](.+)\[/i\]#isU' => '<em>$1</em>'
		], $reflectionMethodGetBbCodes->invoke($bbcode));
	}

	/**
	 * @covers ::loadConfig
	 */
	public function testLoadConfigEmptyWithEmptyFile()
	{
		$bbcode = new BBCode(null);

		$reflectionMethodLoadConfig = new \ReflectionMethod($bbcode, 'loadConfig');
		$reflectionMethodLoadConfig->setAccessible(true);
		$this->assertSame($bbcode, $reflectionMethodLoadConfig->invoke($bbcode, __DIR__ . '/files/constructor-2.ini'));

		$reflectionMethodGetBbCodes = new \ReflectionMethod($bbcode, 'getBbCodes');
		$reflectionMethodGetBbCodes->setAccessible(true);
		$this->assertEquals([], $reflectionMethodGetBbCodes->invoke($bbcode));
	}

	/**
	 * @covers ::loadConfig
	 */
	public function testLoadConfigEmptyWithBBCodeKeyDoesNotExists()
	{
		$bbcode = new BBCode(null);

		$reflectionMethodLoadConfig = new \ReflectionMethod($bbcode, 'loadConfig');
		$reflectionMethodLoadConfig->setAccessible(true);
		$this->assertSame($bbcode, $reflectionMethodLoadConfig->invoke($bbcode, __DIR__ . '/files/constructor-3.ini'));

		$reflectionMethodGetBbCodes = new \ReflectionMethod($bbcode, 'getBbCodes');
		$reflectionMethodGetBbCodes->setAccessible(true);
		$this->assertEquals([], $reflectionMethodGetBbCodes->invoke($bbcode));
	}

	/**
	 * @covers ::loadConfig
	 */
	public function testLoadConfigErrorWithEntryIsNotAnArray()
	{
		$this->setExpectedException(EntryIsNotAnArray::class, 'The entry at index "1" is not an array!');

		$bbcode = new BBCode(null);

		$reflectionMethodLoadConfig = new \ReflectionMethod($bbcode, 'loadConfig');
		$reflectionMethodLoadConfig->setAccessible(true);
		$reflectionMethodLoadConfig->invoke($bbcode, __DIR__ . '/files/constructor-5.php');
	}

	/**
	 * @covers ::loadConfig
	 */
	public function testLoadConfigErrorWithRegexIsNotDefined()
	{
		$this->setExpectedException(RegexIsNotDefined::class, 'The array key "regex" is not defined at index "1"!');

		$bbcode = new BBCode(null);

		$reflectionMethodLoadConfig = new \ReflectionMethod($bbcode, 'loadConfig');
		$reflectionMethodLoadConfig->setAccessible(true);
		$reflectionMethodLoadConfig->invoke($bbcode, __DIR__ . '/files/constructor-6.php');
	}

	/**
	 * @covers ::loadConfig
	 */
	public function testLoadConfigErrorWithReplacementIsNotDefined()
	{
		$this->setExpectedException(ReplacementIsNotDefined::class, 'The array key "replacement" is not defined at index "1"!');

		$bbcode = new BBCode(null);

		$reflectionMethodLoadConfig = new \ReflectionMethod($bbcode, 'loadConfig');
		$reflectionMethodLoadConfig->setAccessible(true);
		$reflectionMethodLoadConfig->invoke($bbcode, __DIR__ . '/files/constructor-7.php');
	}

	/**
	 * @covers ::appendBbCode
	 */
	public function testAppendBbCode()
	{
		$file = __DIR__ . '/files/constructor-2.ini';

		$bbcode = new BBCode($file);

		$reflectionMethodGetBbCodes = new \ReflectionMethod($bbcode, 'getBbCodes');
		$reflectionMethodGetBbCodes->setAccessible(true);

		$reflectionMethodAppendBbCode = new \ReflectionMethod($bbcode, 'appendBbCode');
		$reflectionMethodAppendBbCode->setAccessible(true);

		$this->assertEquals([], $reflectionMethodGetBbCodes->invoke($bbcode));
		$this->assertSame($bbcode, $reflectionMethodAppendBbCode->invoke($bbcode, 'key', 'value'));
		$this->assertEquals([
			'key' => 'value'
		], $reflectionMethodGetBbCodes->invoke($bbcode));
	}

	/**
	 * @covers ::getBbCodes
	 */
	public function testGetBbCodes()
	{
		$file = __DIR__ . '/files/constructor-2.ini';

		$bbcode = new BBCode($file);

		$reflectionMethodGetBbCodes = new \ReflectionMethod($bbcode, 'getBbCodes');
		$reflectionMethodGetBbCodes->setAccessible(true);

		$reflectionMethodAppendBbCode = new \ReflectionMethod($bbcode, 'appendBbCode');
		$reflectionMethodAppendBbCode->setAccessible(true);

		$this->assertEquals([], $reflectionMethodGetBbCodes->invoke($bbcode));
		$this->assertSame($bbcode, $reflectionMethodAppendBbCode->invoke($bbcode, 'key', 'value'));
		$this->assertEquals([
			'key' => 'value'
		], $reflectionMethodGetBbCodes->invoke($bbcode));
	}

	public function dataProviderParse()
	{
		return [
			[__DIR__ . '/files/constructor-2.ini', file_get_contents(__DIR__ . '/files/text-in-1.txt'), file_get_contents(__DIR__ . '/files/text-out-1.txt')],
			[__DIR__ . '/files/constructor-2.ini', file_get_contents(__DIR__ . '/files/text-in-2.txt'), file_get_contents(__DIR__ . '/files/text-out-2.txt')],
			[__DIR__ . '/files/constructor-1.ini', file_get_contents(__DIR__ . '/files/text-in-2.txt'), file_get_contents(__DIR__ . '/files/text-out-3.txt')],
			[__DIR__ . '/files/constructor-1.ini', file_get_contents(__DIR__ . '/files/text-in-4.txt'), file_get_contents(__DIR__ . '/files/text-out-4.txt')],
		];
	}

	/**
	 * @param string $file
	 * @param string $text
	 * @param string $expected
	 * @covers ::parse
	 * @dataProvider dataProviderParse
	 */
	public function testParse($file, $text, $expected)
	{
		$bbcode = new BBCode($file);

		$this->assertSame($expected, $bbcode->parse($text));
	}
}