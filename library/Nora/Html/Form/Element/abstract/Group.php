<?php
/*
 * のらライブラリ
 *---------------------- 
 * 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Html\Form\Element;

use ReflectionClass;


/**
 * フォーム
 */
class Group extends Element
{
	protected $_elements = array(),$_name,$_controls;



	public function __get($name)
	{
		return $this->_elements[$name];
	}

	public function group( $name )
	{
		return $this->addElementArrayIF('ControlGroup',$name,func_get_Args());
	}


	public function fieldset($name, $legend = null)
	{
		return $this->addElementArrayIF('Fieldset',$name,func_get_Args());
	}

	public function addText( $name )
	{
		$element = $this->addElementArrayIF('Text',$name,func_get_Args());
		return $this;
	}
	public function addButton( $name )
	{
		$element = $this->addElementArrayIF('Button',$name,func_get_Args());
		return $this;
	}
	public function addTextarea( $name )
	{
		$element = $this->addElementArrayIF('Textarea',$name,func_get_Args());
		return $this;
	}

	public function getElements( )
	{
		return $this->_elements;
	}

	protected function _isElement( $name, $class = null )
	{
		if( isset($this->_elements[$name]) && ($class == null || $this->_elements[$name] instanceof $class) )
		{
			return true;
		}
		return false;
	}

	public function addElementArrayIF( $type, $name, $args )
	{
		if( !$this->_isElement( $name, $type ) )
		{
			return $this->_elements[$name] = $this->createElementArray( $type, $args );
		}
		return $this->_elements[$name];
	}


	public function createElementArray( $type, $args )
	{
		array_unshift($args, $type);
		return call_user_func_array( array($this,'createElement'), $args );
	}

	public function createElement( $type )
	{
		$rc = new ReflectionClass( __NAMESPACE__.'\\'.$type );
		$args = func_get_args();
		array_shift($args); // Typeを削除する
		$element = $rc->newInstanceArgs($args);
		return $element;
	}

	public function setControls( $attrs =array(),$props = array() )
	{
		$this->_controls = new Controls( $attrs, $props );
		return $this;
	}

	public function hasControls( )
	{
		return $this->_controls ? true: false;
	}

	public function getControls( )
	{
		if( !$this->hasControls() )
		{
			$this->setControls();
		}
		return $this->_controls;
	}

	public function controls( $attrs = array(), $props = array())
	{
		if( !$this->hasControls() )
		{
			$this->setControls( $attrs, $props );
		}
		return $this->getControls();
	}
}
