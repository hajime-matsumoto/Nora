<?php
namespace Nora\Html\Form\Renderer;

class Fieldset extends Renderer
{
	public function render( )
	{
		$text = $this->renderFormat('<fieldset :attributes>'.PHP_EOL);
		$text.= $this->renderFormat('<legend>:legend</legend>'.PHP_EOL);
		$text.= $this->renderChildren().PHP_EOL;
		$text.= '</fieldset>';
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


