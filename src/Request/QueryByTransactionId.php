<?php
namespace HQ\MolpayApi\Request;
use HQ\MolpayApi\Response;

/**
 * Class QueryByTransactionId
 *
 * @author Jakapun Kehachindawat <jakapun.kehachindawat@hotelquickly.com>
 */
class QueryByTransactionId extends RequestAbstract {

	protected $_path = 'q_by_tid.php';
	protected $_method = self::METHOD_GET;

	protected $_mandatoryParams = [
		'txID',
		'amount',
		'domain',
		'skey'
	];

	protected $_optionalParams = [
		'url',
		'type'
	];

	public function getSKey()
	{
		return md5($this->params['txID'].$this->domain.$this->verifyKey.$this->params['amount']);
	}

	public function handleResponse($apiResponse)
	{
		$responseArray = (new Response($apiResponse))->getFormattedResponse(':');

		if ( is_array($responseArray) AND !$this->validateVrfKey($responseArray['VrfKey'], $responseArray['Amount'], $this->verifyKey, $this->domain, $responseArray['TranID'], $responseArray['StatCode']) ) {
//			return 'VrfKey not match'; // TODO: create some constant?
		}

		return $responseArray;
	}
}