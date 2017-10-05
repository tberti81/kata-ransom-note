<?php

namespace RansomNote\Test;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use RansomNote\RansomNoteChecker;
use RansomNote\Validator\MagazineValidator;
use RansomNote\Validator\RansomNoteValidator;

class RansomNoteCheckerTest extends PHPUnit_Framework_TestCase
{
	/** @var RansomNoteChecker */
	private $subject;

	/**
	 * @inheritdoc
	 */
	public function setUp()
	{
		$magazineValidator   = new MagazineValidator();
		$ransomNoteValidator = new RansomNoteValidator();

		$this->subject = new RansomNoteChecker($magazineValidator, $ransomNoteValidator);
	}

	/**
	 * @dataProvider invalidInputProvider
	 *
	 * @param string $input
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testRansomNoteThrowsExceptionWithInvalidInput($input)
	{
		$this->subject->check($input);
	}

	/**
	 * @dataProvider successInputProvider
	 *
	 * @param string $input
	 */
	public function testRansomNoteWithSuccess($input)
	{
		$this->assertEquals('Yes', $this->subject->check($input));
	}

	/**
	 * @dataProvider failureInputProvider
	 *
	 * @param string $input
	 */
	public function testRansomNoteWithFailure($input)
	{
		$this->assertEquals('No', $this->subject->check($input));
	}


	public function invalidInputProvider()
	{
		return [
			// Magazine word count mismatch
			["11 5\nI do not like it at all but thank you very much\nI like it very much"],
			// Random note word count mismatch
			["12 4\nI do not like it at all but thank you very much\nI like it very much"],
			// Invalid character spotted
			["12 5\nI don't like it at all but thank you very much\nI like it very much"],
			// Long word spotted
			["13 5\nI do not really like it at all but thank you very much\nI like it very much"],
			// Word count in out of range
			["0 5\n\nI like it very much"],
		];
	}

	public function successInputProvider()
	{
		return [
			["12 5\nI do not like it at all but thank you very much\nI like it very much"]
		];
	}

	public function failureInputProvider()
	{
		return [
			["5 12\nI like it very much\nI do not like it at all but thank you very much"],
			["12 6\nI do not like it at all but thank you very much\nI like it very very much"]
		];
	}
}