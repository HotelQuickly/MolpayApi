<?php
namespace HQ\MolpayApi\Request;

/**
 * Class DailyTransactionReport
 *
 * @author Jakapun Kehachindawat <jakapun.kehachindawat@hotelquickly.com>
 */
class DailyTransactionReport extends RequestAbstract {

	protected $_path = 'API/PSQ/psq-daily.php';
	protected $_method = self::METHOD_GET;

	protected $_mandatoryParams = [
		'merchantID',
		'rdate',
		'skey'
	];

	protected $_optionalParams = [
		'url',
		'type'
	];

	public function getSKey()
	{
		return md5($this->params['rdate'].$this->domain.$this->verifyKey);
	}

	public function handleResponse($response)
	{
		return $response;
	}
}