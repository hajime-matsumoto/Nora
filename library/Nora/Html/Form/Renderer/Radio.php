<?php
namespace Nora\Html\Form\Renderer;

class Radio extends Renderer
{
	public function render( )
	{
		$text = $this->renderFormat( $this->getFormat() );
		return $text;
	}


}


