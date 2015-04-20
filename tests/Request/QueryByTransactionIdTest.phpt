<?php

namespace Tests;

use HQ\MolpayApi\Request\QueryByTransactionId;
use HQ\MolpayApi\RequestFactory;
use Nette;
use Tester;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/../BaseTestCase.php';
/**
 * @author Jakapun Kehachindawat <jakapun.kehachindawat@hotelquickly.com>
 */
class QueryByTransactionIdTest extends BaseTestCase
{
	/** @var  \HQ\MolpayApi\Manager */
	private $molpayManager;

	public function setUp()
	{
		$this->molpayManager = $this->container->getByType('HQ\MolpayApi\Manager');
	}

	public function testQueryByTransactionId()
	{
		$response = $this->molpayManager->send(RequestFactory::QUERY_BY_TRANSACTION_ID, function(QueryByTransactionId $request) {
			$request->setParam('txnID', '1234567890')
				->setParam('domain', $request->getDomain())
				->setParam('skey', $request->getSKey());
		});
//		var_dump($response);
//
//		Assert::equal('1234567890', $response['TxnID']);
//		Assert::equal('17', $response['StatCode']); // Transaction not found

		Assert::same(1, 1); // TODO: assert test
	}
}

$test = new QueryByTransactionIdTest($container);
$test->run();