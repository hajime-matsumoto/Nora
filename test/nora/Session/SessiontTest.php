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

class SessionTest extends PHPUnit_Framework_TestCase
{
	private $session;

	public function setUp( )
	{
		require_once dirname(__FILE__).'/../../../library/Nora/Core/Nora.php';
		Nora::init( );
		Nora::getInstance()->addComponent('session', 'Nora\Session\Component');
		$this->session = Nora::getInstance( )->session;
	}

	public function testCreateInstance( )
	{
		$this->assertInstanceOf( 'Nora\Session\Manager', $this->session);
	}

	public function testCreateSessionID( )
	{
		$session_id =  $this->session->getMethod( )->genSessionKey( );
		$this->assertTrue( $this->session->getMethod( )->registerSessionKey( $session_id ) );
		$this->assertFalse( $this->session->getMethod( )->registerSessionKey( $session_id ) );
	}

	public function testSessionStart( )
	{
		$this->session->start();
		$this->session['testKey'] = 'data';
		$this->assertArrayHasKey( 'testKey', $this->session );
		$this->session->save();

		$session_key = $this->session->getSessionKey();

		// 新しいセッションを開始した時に
		// データが残っていないかテスト
		$this->session->reset();
		$this->session->start();
		$this->assertArrayNotHasKey( 'testKey', $this->session );

		// 昔のセッションに戻った時にデータを保持しているかテスト
		$this->session->reset();
		$this->session->start( $session_key );
		$this->assertArrayHasKey( 'testKey', $this->session );

		// セッションを破棄するテスト
		$this->session->destroy( );
		$this->assertNotEquals( $this->session->getSessionKey(), $session_key );

		// 復元不能な事を確認
		$this->session->start( $session_key );
		$this->assertNotEquals( $this->session->getSessionKey(), $session_key );
	}
}
