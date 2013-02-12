<?php
namespace Nora\Session;
use Nora\DI;

/**
 * セッションマネージャー
 *
 * セッションキーの保持方法をクッキーにするかゲットにするか悩む
 *
 */
class Manager extends \ArrayObject
{
	private $_method;
	private $_session_key;
	private $_is_started = false;
	private $_enable_autosave = false;

	/**
	 * セッションメソッドをセットする
	 */
	public function setMethod( $method )
	{
		$this->_method = $method;
	}

	/**
	 * セッションメソッドを取得する
	 */
	public function getMethod( )
	{
		return $this->_method;
	}

	/**
	 * セッションキーをセットする
	 */
	public function setSessionKey( $session_key )
	{
		if( $this->_method->checkSessionKey( $session_key ) )
		{
			$this->_session_key = $session_key;
		}
	}

	/**
	 * セッションキーを取得する
	 */
	public function getSessionKey( )
	{
		return $this->_session_key;
	}

	/**
	 * セッションをリセットする
	 */
	public function reset( )
	{
		$this->_session_key = false;
		$this->_is_started = false;
		parent::__construct( array() );
		return $this;
	}

	/**
	 * セッションがスタートされているか。
	 */
	public function isStarted( )
	{
		return $this->_is_started;
	}


	/**
	 * セッションを開始する
	 * 
	 * 既に開始されていればスタートしない。
	 *
	 * @param string セッションキー
	 * @param bool セッションデータを自動保存するか。
	 */
	public function start( $session_key = null, $enable_autosave = true)
	{
		if( $this->isStarted() )
		{
			throw new Exception('既にセッションは開始されています');
		}

		// 自動保存
		$this->_enable_autosave = $enable_autosave;

		// セッションキーが与えられなかったら場合の処理
		if( $session_key == null )
		{
			// 使用可能なセッションキーが取得できるまで繰り返す
			do {
				$session_key = $this->_method->genSessionKey( );
			} while(  false == $this->_method->registerSessionKey( $session_key ) );
			$this->setSessionKey( $session_key );
			$this->_is_started = true;
			return $this;
		}

		// セッションキーが与えられたが使用不可能な場合
		if( !$this->_method->checkSessionKey( $session_key ) )
		{
			return $this->start( null, $enable_autosave );
		}

		// 与えられたセッションキーを有効にする
		$this->setSessionKey( $session_key );

		// リストアする
		$this->restore();

		$this->_is_started = true;

		return $this;
	}

	/**
	 * セッションを破棄
	 */
	public function destroy( )
	{
		$this->_method->destroySessionData( $this->getSessionKey() );
		$this->reset();
	}

	/**
	 * セッションを保存する
	 */
	public function save( )
	{
		$this->_method->saveSessionData( $this->getSessionKey(), $this->getArrayCopy( ));
	}

	/**
	 * セッションを復元する
	 */
	public function restore( )
	{
		$restored_data = $this->_method->restroreSessionData( $this->getSessionKey() );
		parent::__construct( $restored_data );
	}

	/**
	 * スクリプト終了時の処理
	 */
	public function __destruct( )
	{
		if( $this->_enable_autosave )
		{
			$this->save( );
		}
	}
}

class Exception extends \Exception{}
