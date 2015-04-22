<?php

namespace HQ\MolpayApi;

/**
 * Class RequestFactory
 *
 * @author Jakapun Kehachindawat <jakapun.kehachindawat@hotelquickly.com>
 */
class RequestFactory
{
	// These const are Request Names
	const QUERY_BY_TRANSACTION_ID = 'QueryByTransactionId';
	const DAILY_TRANSACTION_REPORT = 'DailyTransactionReport';
	const REVERSAL = 'Reversal';

	private $apiBaseUrl;
	private $domain;
	private $verifyKey;

	/**
	 * @param $apiBaseUrl
	 * @param $domain
	 * @param $verifyKey
	 */
	public function __construct(
		$apiBaseUrl,
		$domain,
		$verifyKey
	) {
		$this->apiBaseUrl = $apiBaseUrl;
		$this->domain = $domain;
		$this->verifyKey = $verifyKey;
	}

	/**
	 * @return string
	 */
	public function getVerifyKey()
	{
		return $this->verifyKey;
	}

	/**
	 * @param $requestName
	 * @return mixed
	 */
	public function create($requestName)
	{
		$class = __NAMESPACE__ . '\Request\\' . $requestName;
		return new $class(
			$this->apiBaseUrl,
			$this->domain,
			$this->verifyKey
		);
	}
}