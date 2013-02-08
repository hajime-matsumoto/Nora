<?php
/*
 * のらテスト
 *---------------------- 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';

// のらヘッダーを読み込む
require_once dirname(__FILE__).'/../../../include/header.php';

class BootstrapperTest extends PHPUnit_Framework_TestCase
{
	private $bootstrapper;

	public function setUp( )
	{
		$this->bootstrapper = new Nora\Bootstrap\Bootstrapper() ;
	}

	public function testCreateInstance()
	{
		$this->assertInstanceOf('Nora\Bootstrap\Bootstrapper', $this->bootstrapper);
	}

	public function testDefineResource( )
	{
		$this->assertTrue( 
			$this->bootstrapper->addResourceClass(
				'NoraResource\Request','request'
			) 
		);

		$this->assertInstanceOf(
			'NoraResource\Request', $this->bootstrapper->bootstrap('request')
		);
	}

	/*
	public function testGetContainer( )
	{
		$this->assertInstanceOf(
			'Nora\Container\Container',
			$this->bootstrapper->getContainer( )
		);
	}

	public function testAddResource()
	{
		$this->assertTrue( $this->bootstrapper->addResource('NoraResource\Request') );
		$this->assertInstanceOf( 
			'Nora\Bootstrap\ResourceIF',
			$this->bootstrapper->bootstrap('NoraResource\Request')
		);
		$this->assertInstanceOf( 
			'Nora\Bootstrap\ResourceIF',
			$this->bootstrapper->bootstrap('NoraResource\Request')
		);
	}
	public function testAddResourceAlias()
	{
		$this->assertTrue( $this->bootstrapper->addResource('NoraResource\Request','request') );
		$this->assertInstanceOf( 
			'Nora\Bootstrap\ResourceIF',
			$this->bootstrapper->bootstrap('request')
		);
	}
	 */

}
