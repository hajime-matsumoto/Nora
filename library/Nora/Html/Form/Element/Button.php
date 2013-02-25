<?php
namespace Nora\Html\Form\Element;

class Button extends Element
{
	protected 
		$_type = 'button',
		$_name = '',
		$_id = '',
		$_value = '';

	private $_format = '<button type=":type" name=":name" id=":id" :builtAttrs>:value</button>';


	public function getId( )
	{
		if( '' == trim($this->_id) )
		{
			return $this->getName();
		}
		return $this->_id;
	}


	public function build( )
	{
		$return_text = $this->autoPropFormat( $this->_format );
		return $return_text;
	}

}
