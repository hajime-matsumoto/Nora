<?php
namespace Nora\Html\Form\Renderer;

class Actions extends Renderer
{
	protected $_attributes = array('class'=>'form-actions');

	public function renderNormal( )
	{
		$text = $this->renderFormat('<div :attributes>'.PHP_EOL);
		$text.= $this->renderChildren().PHP_EOL;
		$text.= '</div>';
		return $text;
	}
	public function renderFrozen( )
	{
		$text = '';
		return $text;
	}
}


