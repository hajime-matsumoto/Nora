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
		Nora::getInstance()->addComponent('userComponent', 'Nora\User\Component', array(
			'authComponent'=>array(
				'class'=>'Nora\Auth\Component',
				'config'=>array(
					'type'=>'file',
					'methodConfig'=>array(
						'authFile'=> NORA_HOME.'/doc/sample/auth/auth.passwd'
					)
				)
			),
			'sessionComponent'=>array(
				'class'=>'Nora\Session\Component',
				'config'=>array(
					'type'=>'file'
				)
			)
		));
		$this->userComponent = Nora::getInstance()->userComponent;
	}

	public function testInstance( )
	{
		$this->assertInstanceOf( 'Nora\User\Component', $this->userComponent);
		$this->assertInstanceOf( 'Nora\Auth\Manager', $this->userComponent->auth);
		$this->assertInstanceOf( 'Nora\Session\Manager', $this->userComponent->session);
	}
}

