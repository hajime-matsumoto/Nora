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

class AuthTest extends PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp( )
	{
		require_once dirname(__FILE__).'/../../../library/Nora/Core/Nora.php';
		Nora::init( );
		Nora::getInstance()->addComponent('auth', 'Nora\Auth\Component', array(
			'type'=>'file',
			'methodConfig'=>array(
				'authFile'=> NORA_HOME.'/doc/sample/auth/auth.passwd'
			)
		));
		$this->auth = Nora::getInstance( )->auth;
	}

	public function testInstance( )
	{
		$this->assertInstanceOf(
			'Nora\Auth\Manager',
			$this->auth
		);
	}

	public function testAuth( )
	{
		$this->assertTrue( $this->auth->auth('admin','admin_passwd') );
		$this->assertFalse( $this->auth->auth('admin','admin_wrong_passwd') );
	}
}

