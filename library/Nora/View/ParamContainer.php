<?php
namespace Nora\View;

use Nora\Container\Container;
use ArrayObject,ArrayIterator;

/**
 * Viewパラメタコンテナ
 *
 * Viewで使う時に安全に使用できるようにエスケープする
 */
trait ParamContainerEscaper
{
	public function escape( $data )
	{
		if(is_string( $data ) )
		{
			return $this->_escape( $data );
		}
		elseif( is_array( $data ) )
		{
			return new ParamContainer( $data );
		}
		elseif( is_object( $data ) )
		{
			return new ParamContainerObject( $data );
		}
	}

	public function _escape( $data )
	{
		return htmlspecialchars( $data );
	}
}

class ParamContainer extends ArrayObject
{
	use ParamContainerEscaper;

	public function __construct( $data = array())
	{
		parent::__construct( $data, 0, 'Nora\View\ParamContainerIterator' );
	}

	public function offsetGet( $name )
	{
		return $this->escape(parent::offsetGet( $name ));
	}

	public function __get( $name )
	{
		return $this->offsetGet( $name );
	}

	public function __set( $name, $value )
	{
		return $this->offsetSet( $name, $value );
	}
}

class ParamContainerObject
{
	use ParamContainerEscaper;

	private $_data;

	public function __construct( $data )
	{
		$this->_data = $data;
	}

	public function __get( $name )
	{
		return $this->escape( $this->_data->$name );
	}

	public function __set( $name, $value )
	{
		$this->_data->$name = $value;
	}

	public function __call( $name, $args )
	{
		return $this->escape( call_user_func_array( array($this,$name), $args ) );
	}
}

class ParamContainerIterator extends ArrayIterator
{
	use ParamContainerEscaper;

	public function current( )
	{
		return $this->escape( parent::current() );
	}
}
