<?php
namespace Nora\Html\Form\Renderer;

class Radio extends Renderer
{
	public function renderNormal( )
	{
		$text = $this->renderFormat( $this->getFormat() );
		return $text;
	}

	public function renderFrozen( )
	{
		$text = $this->getChecked() ? $this->getDispLabel(): '';
		return $text;
	}

}


