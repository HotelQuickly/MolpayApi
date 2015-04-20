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

	public function getFormattedResponse()
	{
		$responseArray = $this->convertToArray($this->responseText);

		if ( empty($responseArray) ) {
			return $this->responseText;
		}

		return $responseArray;
	}

	private function convertToArray($plainText)
	{
		$newArray = array();

		$lines = explode("\n", $plainText);
		foreach ($lines as $line) {
			$kv = explode("=", $line, 2);
			if (isset($kv[0]) AND isset($kv[1])) {
				$newArray[$kv[0]] = $kv[1];
			}
		}

		return $newArray;
	}

}