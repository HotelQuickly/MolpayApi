<?php
namespace HQ\MolpayApi\Request;
use HQ\MolpayApi\Response;

/**
 * Class Reversal
 *
 * @author Jakapun Kehachindawat <jakapun.kehachindawat@hotelquickly.com>
 */
class Reversal extends RequestAbstract {

	protected $_path = 'API/refundAPI/refund.php';
	protected $_method = self::METHOD_POST;

	protected $_mandatoryParams = [
		'txnID',
		'domain',
		'skey'
	];

	protected $_optionalParams = [
		'url',
		'type'
	];

	protected $_responseStatCodeDefinition = [
		00 => 'Success',
		11 => 'Failure',
		12 => 'Invalid or unmatched security hash string',
		13 => 'Not a credit card transaction',
		14 => 'Transaction date more than 3 days',
		15 => 'Requested day is on settlement day',
		16 => 'Forbidden transaction',
		17 => 'Transaction not found'
	];

	public function getSKey()
	{
		return md5($this->params['txnID'].$this->domain.$this->verifyKey);
	}

	public function handleResponse($apiResponse)
	{
		$responseArray = (new Response($apiResponse))->getFormattedResponse('=');

		if ( is_array($responseArray) AND !$this->validateVrfKey($responseArray['VrfKey'], $this->verifyKey, $this->domain, $responseArray['TxnID'], $responseArray['StatCode']) ) {
//			return 'VrfKey not match'; // TODO: create some constant?
		}

		if ( is_array($responseArray) ) {
			$responseArray['StatCodeMsg'] = $this->_responseStatCodeDefinition[$responseArray['StatCode']];
		}

		return $responseArray;
	}
}