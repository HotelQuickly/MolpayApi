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
			$request->setParam('txID', '4488542')
				->setParam('amount', '2.00')
				->setParam('domain', $request->getDomain())
				->setParam('skey', $request->getSKey());
		});

		Assert::equal('4488542', $response['TranID']);
		Assert::equal('11', $response['StatCode']);
	}
}

$test = new QueryByTransactionIdTest($container);
$test->run();