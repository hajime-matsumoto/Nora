<?php
// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';

class NoraTemplatorTestCase extends PHPUnit_Framework_TestCase
{
	public function testTemplator( )
	{
		$templator = new Nora\Template\Templator();
		$this->assertInstanceOf( 'Nora\Template\Templator', $templator );

		$templator->assign('name', 'はじめ');
		$templator->setTemplateFile(NORA_HOME.'/doc/examples/templator/templates/index.tpl');
		$this->assertEquals('Name はじめ'.PHP_EOL, $templator->render() );
	}
}
