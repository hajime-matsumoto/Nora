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

class UserTest extends PHPUnit_Framework_TestCase
{
	private $userComponent;

	public function setUp( )
	{
		require_once dirname(__FILE__).'/../../../library/Nora/Core/Nora.php';
		Nora::init( );

		// Authコンポーネント
		Nora::getInstance()->addComponent('auth', 'Nora\Auth\Component', array(
			'type'=>'file',
			'methodConfig'=>array(
				'authFile'=> NORA_HOME.'/doc/sample/auth/auth.passwd'
			)
		));

		// セッションコンポーネント
		Nora::getInstance()->addComponent('session', 'Nora\Session\Component', array(
			'type'=>'file',
		));

		Nora::getInstance()->addComponent('user', 'Nora\User\Component');
	}

	public function testInstance( )
	{
		$this->assertInstanceOf( 'Nora\Auth\Manager', Nora::getInstance()->component('Auth'));
		$this->assertInstanceOf( 'Nora\Session\Manager', Nora::getInstance()->component('session'));
		$this->assertInstanceOf( 'Nora\User\Manager', Nora::getInstance( )->component('user'));
	}
}

