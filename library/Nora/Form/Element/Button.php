<?php
namespace Nora\Form\Element;

class Button implements ElementObjectIF
{
	use ElementObject;

	public function getType( )
	{
		return 'button';
	}

	public function renderElement( )
	{
		$rendered = '<button type="'.$this->getType().'"'.$this->getAttributes().'>'.$this->getLabel()->getValue().'</button>';
		return $rendered;
	}
}

