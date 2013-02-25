<?php
namespace Nora\Html\Form\Element;

class Text extends Element
{
	protected 
		$_type = 'text',
		$_placeholder ='',
		$_name = '',
		$_id = '',
		$_value = '';

	private $_format = '<input id=":id" name=":name" type=":type" value=":value" :builtAttrs>';


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

