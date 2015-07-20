<?php
namespace DasRed\Parser;

use Zend\Config\Factory;
use DasRed\Parser\Exception\RegexIsNotDefined;
use DasRed\Parser\Exception\ReplacementIsNotDefined;
use DasRed\Parser\Exception\EntryIsNotAnArray;

/**
 * Simple BBCode parser
 */
class BBCode
{

	/**
	 * all valid bb codes
	 * list of key with RegEx and Value with replacemant
	 *
	 * @var array
	 */
	protected $bbCodes = [];

	/**
	 * construct
	 *
	 * @param string $configFile
	 */
	public function __construct($configFile = __DIR__ . '/../config/bbcodes.php')
	{
		if ($configFile !== null)
		{
			$this->loadConfig($configFile);
		}
	}

	/**
	 *
	 * @param string $regex
	 * @param string $replacement
	 * @return self
	 */
	protected function appendBbCode($regex, $replacement)
	{
		$this->bbCodes[$regex] = $replacement;

		return $this;
	}

	/**
	 *
	 * @return array
	 */
	protected function getBbCodes()
	{
		return $this->bbCodes;
	}

	/**
	 *
	 * @param string $configFile
	 * @throws EntryIsNotAnArray
	 * @throws RegexIsNotDefined
	 * @throws ReplacementIsNotDefined
	 * @return self
	 */
	protected function loadConfig($configFile)
	{
		// parse config
		$result = Factory::fromFile($configFile, false, true);

		// no bbcodes or bbcodes are empty in ini file
		if (array_key_exists('bbcodes', $result) === false || is_array($result['bbcodes']) === 0)
		{
			return $this;
		}

		// add all
		foreach ($result['bbcodes'] as $index => $entry)
		{
			if (is_array($entry) === false)
			{
				throw new EntryIsNotAnArray($index);
			}

			// test for regex key
			if (array_key_exists('regex', $entry) === false)
			{
				throw new RegexIsNotDefined($index);
			}

			// test for replacement key
			if (array_key_exists('replacement', $entry) === false)
			{
				throw new ReplacementIsNotDefined($index);
			}

			// append
			$this->appendBbCode($entry['regex'], $entry['replacement']);
		}

		return $this;

	}

	/**
	 * Parse bbCode
	 *
	 * Takes a string as input and replace bbCode by (x)HTML tags
	 *
	 * @param string the text to be parsed
	 * @return string
	 */
	public function parse($str)
	{
		foreach ($this->getBbCodes() as $key => $val)
		{
			$str = preg_replace($key, $val, $str);
		}

		return $str;
	}
}
