<?php
namespace Nora\Form\Element;

use Nora\Container\Container;

class Element
{
	private $_parent;
	private $_children_container;
	private $_value;
	private $_name;
	private $_label;

	public function __construct( $name, $label )
	{
		$this->_name = $name;
		$this->_label = $label;
		$this->_children_container = new Container( );
	}

	public function setParent( $parent )
	{
		$this->_parent = $parent;
	}

	public function getParent( )
	{
		return $this->_parent;
	}

	/** Value値を取得する */
	public function takeValue( )
	{
		if( $this->_value ) 
		{
			return $this->_value;
		}
		return $this->takeDefaultValue( );
	}

	/** 初期値を取得する */
	public function takeDefaultValue( )
	{
		return $this->getParent( )->takeDefaultValue($this->_name);
	}

	public function ifValue( $target, $yes=true, $no =false )
	{
		return $this->takeValue( ) == $target ? $yes: $no;
	}
}

