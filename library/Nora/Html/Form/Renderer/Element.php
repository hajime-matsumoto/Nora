<?php
namespace Nora\Html\Form\Renderer;

class Element extends Renderer
{

	public function render( )
	{
		$text = $this->label()->render();
		$text.= $this->renderFormat( $this->autoPropFormat( $this->getFormat() ) );
		$text.= $this->help()->render();
		return $text;
	}


}


