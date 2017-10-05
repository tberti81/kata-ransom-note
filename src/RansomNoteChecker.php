<?php

namespace RansomNote;

use InvalidArgumentException;
use RansomNote\Validator\MagazineValidator;
use RansomNote\Validator\RansomNoteValidator;

class RansomNoteChecker
{
	/**
	 * @param MagazineValidator   $magazineValidator
	 * @param RansomNoteValidator $ransomNoteValidator
	 */
	public function __construct(MagazineValidator $magazineValidator, RansomNoteValidator $ransomNoteValidator)
	{
		$this->magazineValidator   = $magazineValidator;
		$this->ransomNoteValidator = $ransomNoteValidator;
	}

	/**
	 * @param string $input
	 *
	 * @return string
	 *
	 * @throws InvalidArgumentException
	 */
	public function check($input)
	{
		list($numbers, $magazineWords, $ransomNoteWords) = explode("\n", $input);
		list($magazineWordCount, $ransomNoteWordCount) = explode(' ', $numbers);

		$magazineWords = explode(' ', $magazineWords);
		$ransomNoteWords = explode(' ', $ransomNoteWords);

		$this->magazineValidator->validate((int)$magazineWordCount, $magazineWords);
		$this->ransomNoteValidator->validate((int)$ransomNoteWordCount, $ransomNoteWords);

		// Less words in magazine
		if ($magazineWordCount < $ransomNoteWordCount)
		{
			return 'No';
		}

		foreach ($ransomNoteWords as $ransomNoteWord)
		{
			// Not found in magazine
			if (!in_array($ransomNoteWord, $magazineWords))
			{
				return 'No';
			}

			unset($magazineWords[array_search($ransomNoteWord, $magazineWords)]);
		}

		return 'Yes';
	}
} 