<?php
namespace Nora\View\Helper;

use Nora\Container\Container;

/**
 * ヘルパー: Placeholder
 */
class Placeholder extends Container
{
	use HelperTool;

	private $_prefix;
	private $_postfix;
	private $_indent;
	protected $_separator;
	private $_buff_stack = array();

	/** ダイレクトメソッド */
	public function Placeholder( $name )
	{
		if( !$this->hasData( $name ) )
		{
			$this->setData( $name, new Placeholder() );
		}
		return $this->getData( $name );
	}

	public function set( $value, $placement = 'APPEND' )
	{
		if( $placement == 'APPEND' )
		{
			$this->append( $value );
		}else{
			$this->prepend( $value );
		}
		return $this;
	}

	public function setPrefix( $value )
	{
		$this->_prefix = $value;
		return $this;
	}

	public function setPostfix( $value )
	{
		$this->_postfix = $value;
		return $this;
	}

	public function getPrefix( )
	{
		return $this->_prefix;
	}

	public function getPostfix( )
	{
		return $this->_postfix;
	}

	public function setIndent( $indent )
	{
		$this->_indent = $indent;
		return $this;
	}

	public function getIndent( )
	{
		return $this->_indent;
	}

	public function setSeparator( $separator )
	{
		$this->_separator = $separator;
		return $this;
	}

	public function getSeparator( )
	{
		return $this->_separator;
	}

	public function capStart( $key = false)
	{
		$this->_buff_stack[] = $key;
		ob_start();
	}

	public function capEnd( )
	{
		$key = array_pop($this->_buff_stack);
		if( $key !== false )
		{
			$this->setData( $key, ob_get_contents() );
		}
		else
		{
			$this->set( ob_get_contents() );
		}
		ob_end_clean();
	}

	public function buildAttributes( $attributes )
	{
		$str = "";
		foreach( $attributes as $k=>$v ) 
		{
			$str.= sprintf(' %s="%s"', $k,$v);
		}
		return $str;
	}
	public function toString( )
	{
		$text = "";
		$text.= $this->getPrefix();
		$text.= implode( $this->getSeparator(), $this->toArray() );
		$text.= $this->getPostfix();
		return $text;
	}
}










