<?php
namespace Nora\Form\Element;

class HelpLine implements ElementObjectIF
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
		$rendered = '<span'
			.$this->getAttributes()
			.'>';
		$rendered.= $this->getValue();
		$rendered.='</span>';
		return $rendered;
	}

	public function __toString( )
	{
		return $this->renderElement( );
	}

}

