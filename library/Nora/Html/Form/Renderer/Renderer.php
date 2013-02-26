<?php
namespace Nora\Html\Form\Renderer;


class Renderer
{
	private $_element;
	protected $_attributes = array();

	public function __construct( $element )
	{
		$this->_element = $element;
	}
	public function __get( $name )
	{
		return $this->_element->$name;
	}

	public function __call( $name, $args )
	{
		return call_user_func_Array( array($this->_element,$name), $args );
	}

	public function setAttr( $name, $value = null)
	{
		if(is_array($name))
		{
			foreach($name	as $k=>$v)
			{
				$this->setAttr($k,$v);
			}
			return $this;
		}
		$this->_attributes[$name] = $value;
		return $this;
	}

	public function buildAttributes( )
	{
		return $this->_buildAttributes( $this->_attributes );
	}

	protected function _buildAttributes( $array )
	{
		$parts = array();
		foreach( $array as $k=>$v )
		{
			if( is_array($v)) $v = implode(' ', $v);
			if( is_int($k) )
			{
				$parts[] = $v;
			}
			else
			{
				$parts[] = sprintf('%s="%s"',$k,$v);
			}
		}
		return implode(' ', $parts);
	}

	public function formatParam( $param )
	{
		if( method_exists( $this, $method = 'format'.$param) )
		{
			return call_user_func( array($this,$method) );
		}
		elseif( $this->_element->{'has'.$param}( ) )
		{
			return $this->_element->{'get'.$param}();
		}
		return '';
	}

	public function formatAttributes( )
	{
		return $this->buildAttributes();
	}

	public function renderFormat( $format )
	{
		return preg_replace('/:([a-zA-Z0-9]+)/e', '$this->formatParam("\1")', $format);
	}

	public function error( )
	{
		$this->addClass('error');
		return $this;
	}

	public function success( )
	{
		$this->addClass('success');
		return $this;
	}

	public function addClass( $name )
	{
		$classList = explode(' ', $this->_attributes['class']);
		$classList[] = $name;
		$classList = array_unique($classList);
		$this->_attributes['class'] = implode(' ', $classList);
		return $this;
	}
	public function renderChildren( )
	{
		$parts = array();
		foreach($this->getElements() as $e )
		{
			$parts[] = $e->render();
		}
		return implode(PHP_EOL,$parts);
	}

}
