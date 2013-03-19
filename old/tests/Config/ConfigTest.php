<?php
// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';

class NoraConfigConfigTestCase extends PHPUnit_Framework_TestCase
{
	public function testConfigINI( )
	{
		$config = new Nora\Config\ConfigINI( );
		$config->load( NORA_HOME.'/doc/examples/application/config/application.ini', 'develop');

		$this->assertEquals( 'default', $config['resource']['logging']['type'] );
		$this->assertEquals( 'default', $config->getConfig('resource.logging.type') );
	}
}
