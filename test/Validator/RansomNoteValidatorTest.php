<?php

namespace RansomNote\Test\Validator;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use RansomNote\Validator\RansomNoteValidator;

class RandomNoteValidatorTest extends PHPUnit_Framework_TestCase
{
	/** @var RansomNoteValidator */
	private $subject;

	/**
	 * @inheritdoc
	 */
	public function setUp()
	{
		$this->subject = new RansomNoteValidator();
	}

	/**
	 * @covers RansomNote\Validator\ValidatorAbstract
	 *
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Invalid ransom note input. Word count must match the number of words in the array, seems 3 does not match 2!
	 */
	public function testValidateThrowsExceptionIfWordCountMismatch()
	{
		$this->subject->validate(3, ['bla', 'bla']);
	}

	/**
	 * @covers RansomNote\Validator\ValidatorAbstract
	 *
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Invalid ransom note input. Word count must be between 1 and 30000, given "0"!
	 */
	public function testValidateThrowsExceptionIfWordCountIsOutOfRange()
	{
		$this->subject->validate(0, []);
	}

	/**
	 * @covers RansomNote\Validator\ValidatorAbstract
	 *
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Invalid ransom note input. Each word length must be between 1 and 5 characters and must consists of English alphabetic letters. Given "real." is invalid!
	 */
	public function testValidateThrowsExceptionIfWordContainsInvalidLetter()
	{
		$this->subject->validate(1, ['real.']);
	}

	/**
	 * @covers RansomNote\Validator\ValidatorAbstract
	 *
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Invalid ransom note input. Each word length must be between 1 and 5 characters and must consists of English alphabetic letters. Given "really" is invalid!
	 */
	public function testValidateThrowsExceptionIfWordLengthIsInvalid()
	{
		$this->subject->validate(1, ['really']);
	}
}