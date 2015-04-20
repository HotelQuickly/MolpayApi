<?php

namespace HQ\MolpayApi;

/**
 * Class Response
 *
 * @author Jakapun Kehachindawat <jakapun.kehachindawat@hotelquickly.com>
 */
class Response {

	/** @var string */
	private $responseText;

	public function __construct(
		$responseText
	) {
		$this->responseText = $responseText;
	}

	public function getFormattedResponse($responseParamsDelimiter)
	{
		$responseArray = $this->convertToArray($this->responseText, $responseParamsDelimiter);

		if ( empty($responseArray) ) {
			return $this->responseText;
		}

		return $responseArray;
	}

	private function convertToArray($plainText, $responseParamsDelimiter)
	{
		$newArray = array();

		$lines = explode("\n", $plainText);
		foreach ($lines as $line) {
			$kv = explode($responseParamsDelimiter, $line, 2);
			if (isset($kv[0]) AND isset($kv[1])) {
				$newArray[$kv[0]] = trim($kv[1]);
			}
		}

		return $newArray;
	}

}