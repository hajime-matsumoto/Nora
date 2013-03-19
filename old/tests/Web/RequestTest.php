<?php
// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';

class NoraWebRequestTestCase extends PHPUnit_Framework_TestCase
{
	public function testRequest( )
	{
		$request = new Nora\Web\Request();
		$this->assertInstanceOf('Nora\Web\Request', $request);
	}

	public function testDataSetGet()
	{
		// AutoLoaderにロガーをセット
		nora()->getContainer( )->addComponent('logging','Nora\Logging\Logger');

		$request = new Nora\Web\Request();
		$request['testA'] = 'A';
		$request->set('testB','B');

		$this->assertEquals('A', $request->get('testA'));
		$this->assertEquals('B', $request['testB']);
		$this->assertEquals('C', $request->get('testC','C'));
	}



}
