<?php
/*
 * のらライブラリ
 *---------------------- 
 * 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Form;

/**
 * フォーム
 */
class Renderer
{
	public function __construct( $element )
	{
		$this->_element = $element;
	}

	// 描画
	public function render( )
	{
		// クラスの型で処理を振り分ける
		$class = get_class($this->_element);
		$method = 'render'.substr($class, strrpos($class,'\\')+1);

		if( $this->_element instanceof Form )
		{
			return $this->renderForm( );
		}

		if( method_exists($this,$method) )
		{
			return call_user_func(array($this,$method)).PHP_EOL;
		}
		else
		{
			return $this->renderElement( ).PHP_EOL;
		}
	}

	protected function renderElement( )
	{
		$rendered = '';
		//$rendered.= $this->_element->getLabel()->renderElement();
		$rendered.= $this->_element->renderElement();
		return $rendered;
	}

	protected function renderForm( )
	{
		$rendered = '';
		foreach($this->_element as $v )
		{
			$rendered.= $v->render();
		}
		return $rendered;
	}

	protected function renderGroup( )
	{
		$level = $this->_element->getLevel();
		switch($level)
		{
		case 1:
			return $this->rendereFieldset();
		case 2:
			return $this->rendereControls();
		}

		$rendered = '';
		foreach($this->_element as $v )
		{
			$rendered.= $v->render();
		}
		return $rendered;
	}

	protected function rendereFieldset( )
	{
		$rendered = '';
		$rendered.='<fieldset>'.PHP_EOL;
		$rendered.='<legend>'.$this->_element->getLabel()->getValue().'</legend>'.PHP_EOL;
		foreach($this->_element as $v )
		{
			$rendered.=$v->render();
		}
			$rendered.='</fieldset>';
		return $rendered;
	}

	/*
		<div class="control-group">
		<label class="control-label require-label" for="customer-surname">お名前</label>
		<div class="controls">
		<input type="text" id="customer-surname" name="name01" value="" maxlength="50" class="input-small required" placeholder="姓" x-autocompletetype="surname" autofocus>
		<input type="text" name="name02" value="" maxlength="50" class="input-small required" placeholder="名" x-autocompletetype="given-name">
		</div>
		</div>
	 */
	protected function rendereControls( )
	{
		$rendered = '';
		$rendered.='<div class="control-group">'.PHP_EOL;
		$rendered.= $this->_element->getLabel().PHP_EOL;
		$rendered.='<div class="controls">';
		foreach($this->_element as $v )
		{
			$rendered.=$v->render();
		}
		$helpLine = $this->_element->getHelpLine( );
		$rendered.= $helpLine ? $helpLine->renderElement(): '';
		$rendered.='</div>'.PHP_EOL;
		$rendered.='</div>';
		return $rendered;
	}

	protected function renderActions( )
	{
		$rendered = '';
		$rendered.='<div class="form-actions">'.PHP_EOL;
		foreach($this->_element as $v )
		{
			$rendered.=$v->render();
		}
		$rendered.='</div>';
		return $rendered;
	}

}
