<?php
namespace Nora\View\Helper;

use Nora\Container\Container;
use Nora\Helper;

/**
 * ヘルパー: Placeholder
 */
class Placeholder extends Container implements Helper\HelperObjectIF
{
	use Helper\HelperObject;

	private $_prefix, $_postfix, $_format = "%s", $_separator = "";

	public function __construct( )
	{
	}

	public function setSeparator( $sep )
	{
		$this->_separator = $sep;
		return $this;
	}


	public function setPrefix( $prefix )
	{
		$this->_prefix = $prefix;
		return $this;
	}

	public function setPostfix( $postfix )
	{
		$this->_postfix = $postfix;
		return $this;
	}

	public function setFormat( $format )
	{
		$this->_format = $format;
		return $this;
	}

	protected function getPrefix( )
	{
		return $this->_prefix;
	}

	protected function getPostfix( )
	{
		return $this->_postfix;
	}
	protected function getSeparator( )
	{
		return $this->_separator;
	}

	protected function format( $value )
	{
		if( is_string($value) || $value instanceof Placeholder)
		{
			return sprintf( $this->_format, (string) $value );
		}
		else
		{
			return vsprintf( $this->_format, $value );
		}
	}

	public function Placeholder( $name )
	{
		if( !$this->offsetExists($name))
		{
			$this[$name] = new Placeholder( );
		}
		return $this[$name];
	}

	public function __toString( )
	{
		$datas = array();
		$data = '';
		$data.= $this->getPrefix( );
		foreach($this as $k=>$v)
		{
			$datas[]= $this->format( $v );
		}
		$data.= implode($this->getSeparator(), $datas);
		$data.= $this->getPostfix( );
		return $data;
	}

	public function capStart( )
	{
		ob_start();
	}
	public function capEnd( )
	{
		$this->append( ob_get_contents() );
		ob_end_clean( );
	}
}











