<?php
namespace Nora\Logger;

/**
 * ロギング機能を追加する
 */
trait Logging
{
	private $_logger;

	/** ロガーをセットする */
	public function setLogger( Logger $logger )
	{
		if($logger){
			$this->_logger = $logger;
		}
		return $this;
	}

	/** ロガーを取得する */
	public function getLogger( )
	{
		return $this->_logger;
	}

	/** メッセージを整形 */
	private function _makeMsg( $msgs )
	{
		if( count($msgs) == 1 ){
			$msg = $msgs[0];
		}else{
			$msg = vsprintf($msgs[0],array_slice($msgs,1));
		}
		return $msg;
	}

	/** ロガーを取得する */
	private function logger( )
	{
		if( $this->_logger )
		{
			return $this->_logger;
		}

		if( \Nora\Core\Nora::getInstance( )->hasService('logger') )
		{
			return \Nora\Core\Nora::getInstance( )->service('logger');
		}
		return false;
	}

	/** ロギング */
	public function log( $level, $msg )
	{
		if($this->logger())
		{
			$msg = $this->_makeMsg(array_slice(func_get_args(),1));
			$this->logger()->logging(Logger::LOG, $msg);
		}
	}

	/** デバッグメッセージ */
	public function debug( $msg )
	{
		if($this->logger())
		{
			$msg = $this->_makeMsg(func_get_args());
			$this->logger()->logging(Logger::DEBUG, $msg);
		}
	}

	/** インフォメッセージ */
	public function info( $msg )
	{
		if($this->logger())
		{
			$msg = $this->_makeMsg(func_get_args());
			$this->logger()->logging(Logger::INFO, $msg);
		}
	}

	/** ワーニングメッセージ */
	public function warn( $msg )
	{
		if($this->logger())
		{
			$msg = $this->_makeMsg(func_get_args());
			$this->logger()->logging(Logger::WARN, $msg);
		}
	}

	/** エラーメッセージ */
	public function error( $msg )
	{
		if($this->logger())
		{
			$msg = $this->_makeMsg(func_get_args());
			$this->logger()->logging(Logger::ERROR, $msg);
		}
	}
}
