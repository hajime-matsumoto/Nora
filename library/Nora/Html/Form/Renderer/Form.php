<?php
namespace Nora\Html\Form\Renderer;

class Form extends Renderer
{
	protected $_attributes = array('class'=>'form-horizontal');

	public function render( )
	{
		$text = '';
		$text.= $this->renderFormat( $this->getFormat() ).PHP_EOL;
		$text.= $this->renderChildren().PHP_EOL;
		$text.= $this->actions()->render();
		$text.= '</form>';
		return $text;
	}

	public function renderChildren( )
	{
		$parts = array();
		foreach($this->getElements() as $e )
		{
			$parts[] = $e->render();
		}
		return implode(PHP_EOL,$parts);
	}

}


