<?php
namespace Nora\Logger;

/**
 * ロガー
 */
class File extends Logger
{
	private $_logFilePath, $_logFileMode, $_fp;

	public function __construct( $options )
	{
		$this->_logFilePath = $options['log_file_path'];
		$this->_logFileMode = $options['log_file_mode'];
		$this->_fp = fopen( $this->_logFilePath, $this->_logFileMode );
		flock($this->_fp, LOCK_EX);
		fwrite( $this->_fp, "======== 開始 ==========\n" );
	}

	protected function _logging( $message )
	{
		fwrite( $this->_fp, $message );
	}

	public function __destruct( )
	{
		fwrite( $this->_fp, "======== 終了 ==========\n" );
		flock($this->_fp, LOCK_UN);
		fclose( $this->_fp );
	}

}
