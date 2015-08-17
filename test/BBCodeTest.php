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

		$this->assertFalse($bbcode->isQuoteHtml());
		$this->assertEquals([
			'#\[br\]#i' => '<br>',
			'#\[b\](.+)\[/b\]#isU' => '<strong>$1</strong>',
			'#\[i\](.+)\[/i\]#isU' => '<em>$1</em>'
		], $bbcode->getBbCodes());
	}

	/**
	 * @covers ::__construct
	 */
	public function testConstructorWithNull()
	{
		$bbcode = new BBCode(null, true);

		$this->assertEquals([], $bbcode->getBbCodes());
		$this->assertTrue($bbcode->isQuoteHtml());
	}

	/**
	 * @covers ::loadConfig
	 */
	public function testLoadConfigDefault()
	{
		$bbcode = new BBCode();

		$this->assertEquals([
			'#\[br\]#i' => '<br>',
			'#\[b(.*)\](.+)\[/b\]#isU' => '<strong$1>$2</strong>',
			'#\[i(.*)\](.+)\[/i\]#isU' => '<em$1>$2</em>',
			'#\[u(.*)\](.+)\[/u\]#isU' => '<u$1>$2</u>',
			'#\[h1(.*)\](.+)\[/h1\]#isU' => '<h1$1>$2</h1>',
			'#\[h2(.*)\](.+)\[/h2\]#isU' => '<h2$1>$2</h2>',
			'#\[h3(.*)\](.+)\[/h3\]#isU' => '<h3$1>$2</h3>',
			'#\[h4(.*)\](.+)\[/h4\]#isU' => '<h4$1>$2</h4>',
			'#\[h5(.*)\](.+)\[/h5\]#isU' => '<h5$1>$2</h5>',
			'#\[h6(.*)\](.+)\[/h6\]#isU' => '<h6$1>$2</h6>',
			'#\[p(.*)\](.+)\[/p\]#isU' => '<p$1>$2</p>',
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
		], $bbcode->getBbCodes());
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

		$this->assertEquals([
			'#\[br\]#i' => '<br>',
			'#\[b\](.+)\[/b\]#isU' => '<strong>$1</strong>',
			'#\[i\](.+)\[/i\]#isU' => '<em>$1</em>'
		], $bbcode->getBbCodes());
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

		$this->assertEquals([
			'#\[br\]#i' => '<br>',
			'#\[b\](.+)\[/b\]#isU' => '<strong>$1</strong>',
			'#\[i\](.+)\[/i\]#isU' => '<em>$1</em>'
		], $bbcode->getBbCodes());
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

		$this->assertEquals([], $bbcode->getBbCodes());
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

		$this->assertEquals([], $bbcode->getBbCodes());
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

		$reflectionMethodAppendBbCode = new \ReflectionMethod($bbcode, 'appendBbCode');
		$reflectionMethodAppendBbCode->setAccessible(true);

		$this->assertEquals([], $bbcode->getBbCodes());
		$this->assertSame($bbcode, $reflectionMethodAppendBbCode->invoke($bbcode, 'key', 'value'));
		$this->assertEquals([
			'key' => 'value'
		], $bbcode->getBbCodes());
	}

	/**
	 * @covers ::getBbCodes
	 */
	public function testGetBbCodes()
	{
		$file = __DIR__ . '/files/constructor-2.ini';

		$bbcode = new BBCode($file);

		$reflectionMethodAppendBbCode = new \ReflectionMethod($bbcode, 'appendBbCode');
		$reflectionMethodAppendBbCode->setAccessible(true);

		$this->assertEquals([], $bbcode->getBbCodes());
		$this->assertSame($bbcode, $reflectionMethodAppendBbCode->invoke($bbcode, 'key', 'value'));
		$this->assertEquals([
			'key' => 'value'
		], $bbcode->getBbCodes());
	}

	public function dataProviderParse()
	{
		return [
			[__DIR__ . '/files/constructor-2.ini', file_get_contents(__DIR__ . '/files/text-in-1.txt'), file_get_contents(__DIR__ . '/files/text-out-1.txt'), false],
			[__DIR__ . '/files/constructor-2.ini', file_get_contents(__DIR__ . '/files/text-in-2.txt'), file_get_contents(__DIR__ . '/files/text-out-2.txt'), false],
			[__DIR__ . '/files/constructor-1.ini', file_get_contents(__DIR__ . '/files/text-in-2.txt'), file_get_contents(__DIR__ . '/files/text-out-3.txt'), false],
			[__DIR__ . '/files/constructor-1.ini', file_get_contents(__DIR__ . '/files/text-in-4.txt'), file_get_contents(__DIR__ . '/files/text-out-4.txt'), false],

			[__DIR__ . '/files/constructor-1.ini', file_get_contents(__DIR__ . '/files/text-in-5.txt'), file_get_contents(__DIR__ . '/files/text-out-5.txt'), false],

			[__DIR__ . '/files/constructor-2.ini', file_get_contents(__DIR__ . '/files/text-in-1.txt'), file_get_contents(__DIR__ . '/files/text-out-1.txt'), true],
			[__DIR__ . '/files/constructor-2.ini', file_get_contents(__DIR__ . '/files/text-in-2.txt'), file_get_contents(__DIR__ . '/files/text-out-2.txt'), true],
			[__DIR__ . '/files/constructor-1.ini', file_get_contents(__DIR__ . '/files/text-in-2.txt'), file_get_contents(__DIR__ . '/files/text-out-3.txt'), true],
			[__DIR__ . '/files/constructor-1.ini', file_get_contents(__DIR__ . '/files/text-in-4.txt'), file_get_contents(__DIR__ . '/files/text-out-4.txt'), true],

			[__DIR__ . '/files/constructor-1.ini', file_get_contents(__DIR__ . '/files/text-in-5.txt'), file_get_contents(__DIR__ . '/files/text-out-6.txt'), true],
		];
	}

	/**
	 * @param string $file
	 * @param string $text
	 * @param string $expected
	 * @param bool $quoteHtml
	 * @covers ::parse
	 * @dataProvider dataProviderParse
	 */
	public function testParse($file, $text, $expected, $quoteHtml)
	{
		$bbcode = new BBCode($file, $quoteHtml);

		$this->assertSame($expected, $bbcode->parse($text));
	}

	/**
	 * @covers ::isQuoteHtml
	 * @covers ::setQuoteHtml
	 */
	public function testGetSetQuoteHtml()
	{
		$bbcode = new BBCode();
		$this->assertFalse($bbcode->isQuoteHtml());
		$this->assertSame($bbcode, $bbcode->setQuoteHtml(true));
		$this->assertTrue($bbcode->isQuoteHtml());
	}

	public function dataProviderParseWithQuoting()
	{
		return [
			['abc', 'abc'],
			['<a href="nuff&narf">Hallo [b]Welt[/b]</a>', '&lt;a href=&quot;nuff&amp;narf&quot;&gt;Hallo [b]Welt[/b]&lt;/a&gt;'],
			['<a href="nuff">Nüff [b]löl < gröhl[/b]</a>', '&lt;a href=&quot;nuff&quot;&gt;Nüff [b]löl &lt; gröhl[/b]&lt;/a&gt;'],
			['<a href="n\'uff">Nüff [b]löl < gröhl[/b]</a>', '&lt;a href=&quot;n&#039;uff&quot;&gt;Nüff [b]löl &lt; gröhl[/b]&lt;/a&gt;'],
		];
	}

	/**
	 *
	 * @covers ::parse
	 * @dataProvider dataProviderParseWithQuoting
	 */
	public function testParseWithQuoting($in, $out)
	{
		$bbcode = new BBCode(null, true);

		$this->assertEquals($out, $bbcode->parse($in));
	}
}