<?php

namespace Tests;

use HQ\MolpayApi\Request\Reversal;
use HQ\MolpayApi\RequestFactory;
use Nette;
use Tester;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/../BaseTestCase.php';
/**
 * @author Jakapun Kehachindawat <jakapun.kehachindawat@hotelquickly.com>
 */
class ReversalTest extends BaseTestCase
{
	/** @var  \HQ\MolpayApi\Manager */
	private $molpayManager;

	public function setUp()
	{
		$this->molpayManager = $this->container->getByType('HQ\MolpayApi\Manager');
	}

	public function testReversal()
	{
		$response = $this->molpayManager->send(RequestFactory::REVERSAL, function(Reversal $request) {
			$request->setParam('txnID', '1234567890')
				->setParam('domain', $request->getDomain())
				->setParam('skey', $request->getSKey());
		});

		Assert::equal('1234567890', $response['TxnID']);
		Assert::equal('17', $response['StatCode']); // Transaction not found
		Assert::equal(32, strlen($response['VrfKey']));
	}
}

$test = new ReversalTest($container);
$test->run();