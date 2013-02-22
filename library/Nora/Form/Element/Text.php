<?php
namespace Nora\Form\Element;

class Text implements ElementObjectIF
{
	use ElementObject;
	private $_type = 'text';

	public function setType( $type )
	{
		$this->_type = $type;
	}
	public function getType( )
	{
		return $this->_type;
	}

	public function renderElement( )
	{
		$rendered = '<input type="'.$this->getType().'"'
			.$this->getAttributes()
			.'>';
		return $rendered;
	}

}

