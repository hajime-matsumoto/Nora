<?php
namespace Nora\Html\Form\Renderer;

class Radios extends Renderer
{
	protected $_attributes = array('class'=>'form-actions');

	public function render( )
	{
		$text = '';
		$text.= $this->renderChildren().PHP_EOL;
		return $text;
	}


}


