<?php

	declare( strict_types = 1 );

	function displayKey (string $key) : string
	{
		// printf(" %s ", $key);
		return $key;
	}

	function encodeData (string $inputData, string $generateKey) : string
	{
		$scrambleKey = "abcdefghijklmnopqrstuvwxyz1234567890";
		$result = "";
		$length = strlen($inputData);

		for ($i = 0; $i < $length; $i++) {
			$currentChar = $inputData[$i];
			$characterPos = strpos($scrambleKey, $currentChar);
			if ($characterPos !== false) {
				$result .= $generateKey[$characterPos];
			} else {
				$result .= $currentChar;
			}
		}

		return $result;
	}

	function decodeData (string $inputData, string $generateKey) : string
	{
		$scrambleKey = "abcdefghijklmnopqrstuvwxyz1234567890";
		$result = "";
		$length = strlen($inputData);

		for ($i = 0; $i < $length; $i++) {
			$currentChar = $inputData[$i];
			$characterPos = strpos($generateKey, $currentChar);
			if ($characterPos !== false) {
				$result .= $scrambleKey[$characterPos];
			} else {
				$result .= $currentChar;
			}
		}

		return $result;
	}