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

use Nora\Core\Nora;


class BootstrapperTest extends PHPUnit_Framework_TestCase
{
	private $bootstrapper;

	public function setUp( )
	{
		require_once dirname(__FILE__).'/../../../library/Nora/Core/Nora.php';
		Nora::init();
		Nora::getInstance()->addComponent('logger','Nora\Logger\Component');
	}

	public function testCreateInstance()
	{
		$this->assertInstanceOf('Nora\Bootstrap\Bootstrapper', Nora::getInstance()->component('bootstrap'));
	}

	public function testMethodComponent( )
	{
		// メソッドコンポーネントのテスト
		$this->assertInstanceOf('Nora\Core\Nora',
			Nora::getInstance()->component('bootstrap')->component('nora')
		);
	}

	public function testAsteriskComponent( )
	{
		Nora::getInstance( )
			->component('bootstrap')
			->addComponent('asterisk', 'Nora\Asterisk\Component', array(
				'host'=>'phone.hazime.org',
				'port'=>5038,
				'username'=>'www',
				'secret'=>'deganjue'
			));

		$this->assertInstanceOf( 'Nora\Asterisk\Asterisk', Nora::getInstance( )->component('bootstrap')->component('asterisk'));
		$asterisk = Nora::getInstance( )->component('bootstrap')->component('asterisk');
		$asterisk('RELOAD');
	}

	public function testFindComponent( )
	{
		$bs = Nora::getInstance( )->component('bootstrap');
		$this->assertInstanceOf( 'Nora\Logger\Logger', $bs->findComponent('logger') );
	}
}
