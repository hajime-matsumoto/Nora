<?php
namespace Nora\Html\Form\Renderer;

class Element extends Renderer
{

	public function renderNormal( )
	{
		$text = $this->label()->render();
		$text.= $this->renderFormat( $this->autoPropFormat( $this->getFormat() ) );
		$text.= $this->help()->render();
		return $text;
	}

	public function renderFrozen( )
	{
		$text = '';
		$text.= nl2br($this->getValue());
		return $text;
	}


}


