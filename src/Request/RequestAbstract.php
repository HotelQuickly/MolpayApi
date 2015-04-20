<?php

namespace HQ\MolpayApi\Request;

/**
 * Class RequestAbstract
 *
 * @author Jakapun Kehachindawat <jakapun.kehachindawat@hotelquickly.com>
 */
abstract class RequestAbstract {

	const METHOD_POST = 'POST';
	const METHOD_GET = 'GET';

	protected $apiBaseUrl;
	protected $domain;
	protected $verifyKey;

	protected $params = [];

	protected $_path;
	protected $_method;
	protected $_mandatoryParams = [];
	protected $_optionalParams = [];
	protected $_responseStatCodeDefinition = [];

	public function __construct(
		$apiBaseUrl,
		$domain,
		$verifyKey
	) {
		$this->apiBaseUrl = $apiBaseUrl;
		$this->domain = $domain;
		$this->verifyKey = $verifyKey;
	}

	abstract public function getSKey();
	abstract public function handleResponse($response);

	public function validateVrfKey($responseVrfKey)
	{
		$str = '';
		for ($i = 1; $i <= func_num_args()-1; $i++) {
			$str .= func_get_arg($i);
		}

//		var_dump($responseVrfKey);
//		var_dump(md5($str));die();

		return ($responseVrfKey == md5($str));
	}

	public function getDomain()
	{
		return $this->domain;
	}

	public function getFullRequestUrl()
	{
		return $this->apiBaseUrl .'/'. $this->_path;
	}

	public function getMethod()
	{
		return $this->_method;
	}

	public function buildParams()
	{
		$string = '';
		foreach ($this->params as $k=>$v) {
			$string .= $k.'='.$v.'&';
		}
		return rtrim($string, '&');
	}

	public function setParam($name, $value)
	{
		if ( !in_array($name, $this->getKeys($this->_mandatoryParams)) AND !in_array($name, $this->getKeys($this->_optionalParams)) ) {
			throw new \Exception("Trying to set un-allowed param: {$name}");
		}
		$this->params[$name] = $value;

		return $this;
	}

	public function getParam($name)
	{
		if ( !in_array($name, $this->getKeys($this->params)) ) {
			throw new \Exception("Trying to get unknown param: {$name}");
		}
		return $this->params[$name];
	}

	public function validateRequest()
	{
		$missingParamArray = array_diff_key($this->getKeys($this->_mandatoryParams), $this->getKeys($this->params));
		if ( !empty($missingParamArray) ) {
			throw new \Exception("Missing mandatory params: ". implode(',', $missingParamArray));
		}
	}

	private function getKeys(array $data)
	{
		$keys = [];
		foreach($data as $key => $val) {
			$keys[] = is_string($key) ? $key : $val;
		}

		return $keys;
	}
}