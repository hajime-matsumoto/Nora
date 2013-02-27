<?php
/**
 * のらライブラリ
 */
namespace Nora\DB;

use Nora\Logger;


/**
 * クエリステートメント
 */
class Statement
{
	use Logger\Logging;

	private $_sql_format;
	private $_db;
	private $_bind_params = array();
	private $_bind_param_types = array();

	public function __construct( $sql,  $db )
	{
		$this->_sql_format = $sql;
		$this->_db = $db;
	}

	public function bindString( $name, $param )
	{
		$this->bind( $name, $param, 'string');
	}
	public function bindInt( $name, $param )
	{
		$this->bind( $name, $param, 'int');
	}

	public function bind( $name, $param, $type = 'string')
	{
		$this->_bind_params[$name] = $param;
		$this->_bind_param_types[$name] = $type;
	}

	public function execute( )
	{
		$sql = preg_replace('/:([a-zA-Z0-9_]+)/e', '$this->param("\1")', $this->_sql_format);
		$this->_db->query( $sql );
	}

	public function param( $name )
	{
		if(!isset($this->_bind_params[$name]))
		{
			$this->error("Statement Placeholder Error %s", $name );
		}
		$value = $this->_bind_params[$name];
		$type  = $this->_bind_param_types[$name];
		return call_user_func( array($this,'quote'.ucfirst($type)), $value);
	}

	public function quoteString( $value )
	{
		return sprintf('"%s"',$this->_db->escape($value));
	}

	public function quoteInt( $value )
	{
		return intval($value);
	}
}
