<?php
namespace Nora\Html\Form\Element;

use Nora\Html\Form;

/**
 * コントロールグループ
 */
class Group extends Element
{
	use Form\FactorySet;

	protected $_renderer = 'Nora\Html\Form\Renderer\Group';
	private $_elements = array();

	public function addElement( $name )
	{
		if( $name instanceof Element )
		{
			foreach( func_get_args() as $element )
			{
				$id = $element->getId();
				$this->_elements[$id] = $element;
			}
		}
		return $this;
	}

	public function getElements( )
	{
		return $this->_elements;
	}

	public function __get($name)
	{
		return $this->_elements[$name];
	}
	
	public function search($q)
	{
		if( $q instanceof \Closure )
		{
			$result = array();
			foreach( $this->_elements as $k=>$v)
			{
				if( $v instanceof Group )
				{
					$result = array_merge($result,$v->search($q));
				}elseif( $q($v) )
				{
					$result[] = $v;
				}
			}
			return $result;
		}
		if( is_array($q) )
		{
			return $this->search(function($e)use($q){ return in_array($e->getId(), $q); });
		}
	}

	public function each( $cb )
	{
		foreach( $this->_elements as $k=>$v )
		{
			call_user_func($cb, $v);
		}
		return $this;
	}
}


