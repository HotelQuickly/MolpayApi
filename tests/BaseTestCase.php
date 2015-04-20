<?php
namespace Tests;

use Nette,
	Tester;

/**
 * @author Jakapun Kehachindawat <jakapun.kehachindawat@gmail.com>
 */
abstract class BaseTestCase extends Tester\TestCase
{
	/** @var \Nette\DI\Container */
	protected $container;

	public function __construct(Nette\DI\Container $container = null)
	{
		$this->container = $container;
	}
	protected function setUp()
	{

	}

}