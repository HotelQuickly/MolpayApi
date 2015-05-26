<?php
require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();

$configurator = new Nette\Configurator;
$configurator->setDebugMode(FALSE);
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(__DIR__ . '/../src')
	->register();
$configurator->addConfig(__DIR__ . '/config/config.neon', false);

$configurator->onCompile[] = function ($configurator, $compiler) {
	$compiler->addExtension('molpayApi', new \HQ\MolpayApi\MolpayApiExtension());
};

return $configurator->createContainer();