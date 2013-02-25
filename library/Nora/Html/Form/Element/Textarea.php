<?php
namespace Nora\Html\Form\Element;

class Textarea extends Text
{
	protected 
		$_type = 'text',
		$_placeholder ='',
		$_name = '',
		$_id = '',
		$_value = '';

	private $_format = '<textarea id=":id" name=":name" :builtAttrs>:value</textarea>';

	public function build( )
	{
		$return_text = $this->autoPropFormat( $this->_format );
		return $return_text;
	}

}

