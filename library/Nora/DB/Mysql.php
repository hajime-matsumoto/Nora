<?php
/**
 * のらライブラリ
 */
namespace Nora\DB;


/**
 * Database Controller
 */
class Mysql extends DB
{
	private $_driver;
	private $_host = 'localhost';
	private $_user = '';
	private $_passwd = '';
	private $_dbname = '';

	public function __construct( $dsn, $user, $passwd )
	{
		$this->_user = $user;
		$this->_passwd = $passwd;
		// Typeを捨てる
		strtok($dsn,':');

		while( $part = strtok(';') )
		{
			$tmp = explode('=', $part);
			$this->{'_'.$tmp[0]} = $tmp[1];
		}

		$this->_driver = new \Mysqli( $this->_host, $this->_user, $this->_passwd, $this->_dbname );
		if ($this->_driver->connect_error) {
			$this->error('DBに接続できません[Error:%s] %s',  $this->_driver->connect_errno, $this->_driver->connect_error );
		}
		$this->query('SET NAMES UTF8');
	}

	public function prepare( $sql )
	{
		return new Statement( $sql, $this );
	}

	public function escape( $value )
	{
		return $this->_driver->real_escape_string($value);
	}

	public function query( $sql )
	{
		$this->debug('Send Query: %s',$sql);
		$result = $this->_driver->query( $sql );
		if( $result == false )
		{
			$this->error('Query Error:%s', $this->_driver->error);
		}

		return $result;
	}
}
