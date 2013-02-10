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
		Nora( )->getContainer( )->addService( 'logger', new \Nora\Logger\Logger());

		$this->bootstrapper = new Nora\Bootstrap\Bootstrapper() ;
	}

	public function testCreateInstance()
	{
		$this->assertInstanceOf('Nora\Bootstrap\Bootstrapper', $this->bootstrapper);
	}

	public function testBootstrap()
	{
		$this->bootstrapper->setResource( 'asterisk', 'NoraResource\Asterisk' );
		$this->bootstrapper->configResource( 'asterisk', array(
			'host'=>'phone.hazime.org',
			'port'=>5038,
			'username'=>'www',
			'secret'=>'deganjue'
		));
		$this->assertInstanceOf(
			'\Nora\Asterisk\Asterisk',
			$asterisk = $this->bootstrapper->bootstrap( 'asterisk' )
		);

		$asterisk->command( 'reload' );
	}
}
