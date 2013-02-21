<?php
namespace Nora\View;

use ArrayObject,ArrayIterator,Traversable;

trait EscapeWrapperTool
{
	private $_data;

	public function __construct( $data )
	{
		$this->_data = $data;
	}

	public function __get( $name )
	{
		return EscapeWrapper::escape( $this->_data->$name );
	}

	public function __call( $name, $args )
	{
		return EscapeWrapper::escape( call_user_func_array( array($this,$name), $args ) );
	}
}

/**
 * Viewパラメタエスケーパー
 *
 * Viewで使う時に安全に使用できるようにエスケープする
 */
class EscapeWrapper 
{
	/**
	 * データの型を判定して、適切にエスケープする
	 */
	static public function escape( $data )
	{
		// エスケープしない
		if( (!is_string($data) && is_scalar( $data )) ||
			$data instanceof EscapeWrapperNone || 
			$data instanceof EscapeWrapperArray || 
			$data instanceof EscapeWrapperObject )
		{
			return $data;
		}
		// 文字列ならば単純にエスケープする
		elseif( is_string( $data ) )
		{
			return htmlspecialchars($data);
		}
		// 配列、もしくはArrayObject,Iteratableならば、
		// イテレーターラッパーへ
		elseif( is_array($data) || $data instanceof Traversable )
		{
			return new EscapeWrapperArray( $data );
		}
		// オブジェクトはオブジェクトラッパーへ
		elseif( is_object( $data ) )
		{
			return new EscapeWrapperObject( $data );
		}
	}
}

class EscapeWrapperArray extends ArrayObject
{
	use EscapeWrapperTool;

	public function __construct( $data )
	{
		parent::__construct( $data, 0, 'Nora\View\EscapeWrapperIterator' );
	}

	public function offsetGet( $name )
	{
		return EscapeWrapper::escape(parent::offsetGet( $name ));
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

class EscapeWrapperObject
{
	use EscapeWrapperTool;
}
 
class EscapeWrapperIterator extends ArrayIterator
{
	public function current()
	{
		return EscapeWrapper::escape( parent::current() );
	}
}

class EscapeWrapperNone
{
	use EscapeWrapperTool;

	public function __get( $name )
	{
		return $this->_data->$name;
	}

	public function __call( $name, $args )
	{
		return call_user_func_array( array($this->_data,$name), $args );
	}
}
