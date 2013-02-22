<?php
namespace Nora\Form\Element;

class Label implements ElementObjectIF
{
	use ElementObject;
	private $_type = 'text';

	public function __construct( $value )
	{
		$this->_value = $value;
	}

	public function getValue()
	{
		return $this->_value;
	}

	public function renderElement( )
	{
		$rendered = '<label'
			.$this->getAttributes()
			.'>';
		$rendered.= $this->getValue();
		$rendered.='</label>';
		return $rendered;
	}

	public function __toString( )
	{
		return $this->renderElement( );
	}

}

