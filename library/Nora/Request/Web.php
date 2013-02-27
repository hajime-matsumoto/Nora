<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Request;

/**
 * リクエスト
 */
class Web extends \ArrayObject implements RequestObjectIF
{
	use RequestObject;

	private $_escape_method = 'htmlspecialchars';

	public function __construct( )
	{
		parent::__construct( array_merge($_POST,$_GET), 0 );
	}

	public function getIterator( )
	{
		return new RequestIterator( $this->getArrayCopy(), function($value){ return $this->escape($value);} );
	}

	public function setEscapeMethod( $method )
	{
		$this->_escape_method = $method;
		return $this;
	}

	public function rawVars( )
	{
		return $this->getArrayCopy();
	}

	public function escape( $value )
	{
		if( is_string($this->_escape_method) )
		{
			$value = call_user_func($this->_escape_method, $value );
		}
		elseif( $this->_escape_method instanceof \Closure )
		{
			$metho = $this->_escape_method;
			$value = $method( $value );
		}
		return $value;
	}

	public function raw( $name )
	{
		return parent::offsetGet($name);
	}

	public function offsetGet( $name )
	{
		return $this->escape( parent::offsetGet( $name ) );
	}

	public function isPost( )
	{
		return 'post' == strtolower($_SERVER['REQUEST_METHOD']) ? true: false;
	}

	public function isGet( )
	{
		return 'get' == strtolower($_SERVER['REQUEST_METHOD']) ? true: false;
	}
}
