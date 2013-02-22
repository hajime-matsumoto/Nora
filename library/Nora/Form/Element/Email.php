<?php
namespace Nora\Form\Element;

class Email extends Text
{
	public function init( )
	{
		$this->setType( 'email' );
	}
}

