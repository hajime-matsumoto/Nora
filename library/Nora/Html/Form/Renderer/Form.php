<?php
namespace Nora\Html\Form\Renderer;

class Form extends Renderer
{
	protected $_attributes = array('class'=>'form-horizontal');

	public function render( )
	{
		$text = '';
		$text.= $this->renderFormat( $this->getFormat() ).PHP_EOL;
		$text.= $this->renderMessage( ).PHP_EOL;
		$text.= $this->renderHiddens();
		$text.= $this->renderChildren().PHP_EOL;
		$text.= $this->actions()->render();
		$text.= '</form>';
		return $text;
	}

	public function renderMessage( )
	{
		if( $this->getMessage() )
		{
			return '<div class="alert alert-'.$this->getMessageType().'">'.$this->getMessage().'</div>';
		}
	}

	public function renderHiddens( )
	{
		$parts = array();
		foreach($this->getHiddenDatas( ) as $k=>$v)
		{
			$parts[] = sprintf('<input type="hidden" name="%s" value="%s">', $k, htmlspecialchars($v));
		}
		return implode("\n", $parts);
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


