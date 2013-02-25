<?php
namespace Nora\Form\Element;

class Textarea implements ElementObjectIF
{
	use ElementObject;

	public function renderElement( )
	{
		$rendered = '<textarea'
			.$this->getAttributes()
			.'></textarea>';
		return $rendered;
	}

}

