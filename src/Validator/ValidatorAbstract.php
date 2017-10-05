<?php

namespace RansomNote\Validator;

use InvalidArgumentException;

abstract class ValidatorAbstract
{
	private $validatorType;

	abstract protected function getValidatorType();

	public function __construct()
	{
		$this->validatorType = $this->getValidatorType();
	}

	/**
	 * @param int   $wordCount
	 * @param array $words
	 *
	 * @throws InvalidArgumentException
	 */
	public function validate($wordCount, array $words)
	{
		$this->validateWordCountMatch($wordCount, $words);

		$this->validateWordCountInRange($wordCount);

		$this->validateWordLetters($words);
	}

	/**
	 * @param int   $wordCount
	 * @param array $words
	 *
	 * @throws InvalidArgumentException
	 */
	private function validateWordCountMatch($wordCount, array $words)
	{
		if (count($words) !== $wordCount)
		{
			throw new InvalidArgumentException(
				sprintf(
					'Invalid %s input. Word count must match the number of words in the array, seems %d does not match %d!',
					$this->validatorType,
					$wordCount,
					count($words)
				)
			);
		}
	}

	/**
	 * @param int $wordCount
	 *
	 * @throws InvalidArgumentException
	 */
	private function validateWordCountInRange($wordCount)
	{
		if ($wordCount < 1 || $wordCount > 30000)
		{
			throw new InvalidArgumentException(
				sprintf(
					'Invalid %s input. Word count must be between 1 and 30000, given "%d"!',
					$this->validatorType,
					$wordCount
				)
			);
		}
	}

	/**
	 * @param array $words
	 *
	 * @throws InvalidArgumentException
	 */
	private function validateWordLetters(array $words)
	{
		foreach ($words as $word)
		{
			if (!preg_match('/^[a-zA-Z]{1,5}$/', $word))
			{
				throw new InvalidArgumentException(
					sprintf(
						'Invalid %s input. Each word length must be between 1 and 5 characters and must consists of English alphabetic letters. Given "%s" is invalid!',
						$this->validatorType,
						$word
					)
				);
			}
		}
	}
}