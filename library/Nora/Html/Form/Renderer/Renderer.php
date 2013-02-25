<?php
/*
 * のらライブラリ
 *---------------------- 
 * 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Html\Form\Renderer;
use Nora\Html\Form;

/**
 * フォーム
 */
class Renderer
{
	private $_element;

	public function __construct( $element )
	{
		$this->_element = $element;
	}

	public function render()
	{
		$class = get_class($this->_element);
		$name  = substr($class,strrpos($class,'\\')+1);

		if( $this->_element instanceof Form\Form )
		{
			return call_user_func( array($this,'renderForm') );
		}

		if( method_exists( $this, $method = 'render'.$name ) )
		{
			return call_user_func( array($this,$method) );
		}

		return $this->renderElement();
	}

	public function renderForm( )
	{
		$text = $this->autoPropFormat('<form:builtAttrs>'.PHP_EOL);
		$text.= $this->renderChildren();
		$text.= $this->autoPropFormat(PHP_EOL.'</form>');
		return $text;
	}

	public function renderFieldset( )
	{
		$text = $this->autoPropFormat('<fieldset:builtAttrs>'.PHP_EOL);
		$text.= $this->autoPropFormat('<legend>:legend</legend>'.PHP_EOL);
		if( $this->hasControls() )
		{
			$text.= $this->getControls( )->render();
		}
		$text.= $this->renderChildren();
		$text.= $this->autoPropFormat(PHP_EOL.'</fieldset>');
		return $text;
	}

	public function renderControls( )
	{
		$text = $this->autoPropFormat('<div:builtAttrs>'.PHP_EOL);
		if( $this->hasLabel() )
		{
			$text.= $this->getLabel().PHP_EOL;
		}
		$text.= $this->renderChildren();
		if( $this->hasHelp() )
		{
			$text.= $this->getHelp( )->render();
		}
		$text.= $this->autoPropFormat(PHP_EOL.'</div>');
		return $text;
	}

	public function renderHelp( )
	{
		return $this->autoPropFormat('<span class="help-line mini">:help</span>');
	}

	public function renderControlGroup( )
	{
		$text = $this->autoPropFormat('<div:builtAttrs>'.PHP_EOL);
		if( $this->hasLabel() )
		{
			$text.= $this->getLabel().PHP_EOL;
		}
		if( $this->hasControls() )
		{
			$text.= $this->getControls( )->render();
		}
		$text.= $this->renderChildren();
		if( $this->hasHelp() )
		{
			$text.= $this->getHelp( )->render();
		}
		$text.= $this->autoPropFormat(PHP_EOL.'</div>');
		return $text;
	}

	public function renderElement( )
	{
		return $this->_element->build();
	}

	public function renderChildren( )
	{
		$parts = array();
		foreach($this->getElements() as $e )
		{
			$parts[] = $e->render();
		}
		return implode( "\n", $parts);
	}

	public function __call( $name, $args )
	{
		return call_user_func_array( array($this->_element,$name), $args );
	}

	public function __get( $name )
	{
		return $this->_element->$name;
	}

}
