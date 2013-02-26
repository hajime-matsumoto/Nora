<?php
namespace Nora\Html\Form\Renderer;

class Group extends Renderer
{
	private $_controls_attrs = array('class'=>'controls');
	protected $_attributes = array('class'=>'control-group');

	public function setControlsAttr( $name, $value )
	{
		$this->_controls_attrs[$name] = $value;
		return $this;
	}

	public function formatControlsAttributes( )
	{
		return $this->_buildAttributes( $this->_controls_attrs );
	}

	public function render( )
	{
		$text = $this->renderFormat('<div :attributes>'.PHP_EOL);
		$text.= $this->label()->render().PHP_EOL;
		$text.= $this->renderFormat('<div :controlsAttributes>'.PHP_EOL);
		$text.= $this->renderChildren().PHP_EOL;
		$text.= $this->help()->render().PHP_EOL;
		$text.= '</div>'.PHP_EOL;
		$text.= '</div>';
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


