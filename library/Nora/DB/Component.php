<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\DB;
use Nora\DI;

/**
 * データベース接続コンポーネント
 */
class Component extends DI\Component implements DI\ComponentIF
{
	private $_dsn;

	public function factory( )
	{
		$dsn = sprintf('%s:dbname=%s;host=%s;port=%s', $this->_type, $this->_dbname, $this->_dbhost, $this->_dbport);
		return DB::connect( 'PDO', $dsn, $this->_dbuser, $this->_dbpassword );
	}


	public function configType( $value )
	{
		$this->_type = $value;
	}

	public function configDBName( $value )
	{
		$this->_dbname = $value;
	}

	public function configDBPort( $value )
	{
		$this->_dbport = $value;
	}

	public function configDBHost( $value )
	{
		$this->_dbhost = $value;
	}

	public function configDBUser( $value )
	{
		$this->_dbuser = $value;
	}

	public function configDBPassword( $value )
	{
		$this->_dbpassword = $value;
	}
}
