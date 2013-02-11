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
		Nora::getInstance()->configComponent('logger',array(
			'type'=>'file',
			'config'=>array(
				'log_file_path'=>'/tmp/nora-log',
				'log_file_mode'=>'w'
			)
		));

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
		Nora::getInstance( )->component('bootstrap')
			->addComponent('asterisk', 'Nora\Asterisk\Component')
			->configComponent('asterisk', array(
				'host'=>'phone.hazime.org',
				'port'=>5038,
				'username'=>'www',
				'secret'=>'deganjue'
			));

		$this->assertInstanceOf(
			'Nora\Asterisk\Asterisk',
			Nora::getInstance( )->component('bootstrap')->component('asterisk')
		);
		Nora::getInstance( )->component('bootstrap')->component('asterisk')->command('RELOAD');
	}
}
