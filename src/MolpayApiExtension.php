<?php
namespace HQ\MolpayApi;
use Nette;
// compatibility for nette 2.0.x and 2.1.x
if (!class_exists('Nette\DI\CompilerExtension')) {
	class_alias('Nette\Config\CompilerExtension', 'Nette\DI\CompilerExtension');
}

/**
 * Class MolpayApiExtension
 *
 * @author Jakapun Kehachindawat <jakapun.kehachindawat@hotelquickly.com>
 */
class MolpayApiExtension extends Nette\DI\CompilerExtension
{
	public $defaults = array(
		'apiBaseUrl' => 'https://tap-nexus.appspot.com/api',
		'domain' => 'abc',
		'verifyKey' => 'abc'
	);

	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		// add service molpayRequestFactory
		$builder->addDefinition('molpayRequestFactory')
			->setClass('\HQ\MolpayApi\RequestFactory', array($config['apiBaseUrl'], $config['domain'], $config['verifyKey']));

		// add service molpayManager
		$builder->addDefinition('molpayManager')
			->setClass('\HQ\MolpayApi\Manager', array('@molpayRequestFactory'));
	}
}