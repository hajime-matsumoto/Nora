<?php
namespace Nora\Logger;

class Logger
{
	const DEBUG = 1;
	const INFO = 2;
	const NOTICE = 4;
	const WARN = 8;
	const ERROR = 16;
	const ALL = 31;

	private $_reporting_level = 31;

	private $_log_format = "[%level] %date %message \n";
	private $_date_format = 'Y-m-d G:i:s';

	/** ロガーを作成する */
	static public function factory( $type )
	{
		$args = array_slice(func_get_args(),1);
		$class =  $type;
		$rc = new \ReflectionClass(__NAMESPACE__.'\\'.$type);
		return $rc->newInstanceArgs($args);
	}

	/** フォーマットを指定する */
	public function setLogFormat( $format )
	{
		$this->_log_format = $format;
	}

	/** ログをフォーマットする */
	public function logFormat( $level, $msg )
	{
		$replaces = array(
			'%level'=>$this->level($level),
			'%message'=>trim($msg),
			'%date'=>date( $this->_date_format )
		);

		return str_replace( array_keys( $replaces ), array_values( $replaces ) , $this->_log_format );
	}


	/** ロギングを受け付ける */
	public function logging($level, $msg)
	{
		if( $level & $this->_reporting_level ){
			$this->_logging( $this->logFormat(  $level, $msg ) );
		}
	}

	/** ロギングを実行する */
	protected function _logging( $message )
	{
		echo $message;
	}

	/** ログレベルを名前に変換 */
	public function level($level)
	{
		switch($level){
		case self::DEBUG:
			return 'debug';
			break;
		case self::INFO:
			return 'info';
			break;
		case self::NOTICE:
			return 'notice';
			break;
		case self::WARN:
			return 'warn';
			break;
		case self::ERROR:
			return 'error';
			break;
		default:
			return 'unknown('.$level.')';
			break;
		}
	}

	/** PHPエラーをこのロガーでハンドルする */
	public function register()
	{
		set_error_handler( array($this,'phpError') );
		return $this;
	}

	/** PHPエラー用のハンドラ */
	public function phpError($errno,$errstr,$errfile,$errline)
	{
		switch ($errno) {
		case E_USER_ERROR:
		case E_ERROR:
			$no = self::ERROR;
			break;
		case E_USER_WARNING:
		case E_WARNING:
			$no = self::WARN;
			break;
		case E_USER_NOTICE:
		case E_NOTICE:
			$no = self::NOTICE;
			break;
		default:
			$no = $errno;
			break;
		}
		$str = sprintf('%s %s %s',$errstr, $errfile, $errline);
		$this->log($no, $str);
	}
}
