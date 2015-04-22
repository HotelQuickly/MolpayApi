<?php

namespace HQ\MolpayApi;

/**
 * Class Manager
 *
 * @author Jakapun Kehachindawat <jakapun.kehachindawat@hotelquickly.com>
 */
class Manager {

	/** @var Sender  */
	private $sender;

	/** @var RequestFactory  */
	private $requestFactory;

	/**
	 * @param RequestFactory $requestFactory
	 */
	public function __construct(
		RequestFactory $requestFactory
	) {
		$this->sender = new Sender();
		$this->requestFactory = $requestFactory;
	}

	/**
	 * @return RequestFactory
	 */
	public function getRequestFactory()
	{
		return $this->requestFactory;
	}

	/**
	 * @param $requestName
	 * @param callable $callback
	 * @return mixed
	 */
	public function send($requestName, \Closure $callback = null)
	{
		$request = $this->requestFactory->create($requestName);

		if ($callback) {
			$callback($request);
		}

		// validate request
		$request->validateRequest();

		$apiResponse = $this->sender->send($request);
		return $request->handleResponse($apiResponse);
	}

}