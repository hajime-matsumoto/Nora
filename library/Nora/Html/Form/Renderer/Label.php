<?php
namespace Nora\Html\Form\Renderer;

class Label extends Renderer
{
	protected $_attributes = array('class'=>'control-label');

	public function render( )
	{
		if( $this->isEnabled() )
		{
			return $this->renderFormat( $this->getFormat( ));
		}
	}

}


