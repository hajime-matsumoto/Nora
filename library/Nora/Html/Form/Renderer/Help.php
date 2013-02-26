<?php
namespace Nora\Html\Form\Renderer;

class Help extends Renderer
{

	public function render( )
	{
		if( $this->isEnabled() )
		{
			return '<p class="help-block">'.$this->getHelp().'</p>';
		}
	}

}


