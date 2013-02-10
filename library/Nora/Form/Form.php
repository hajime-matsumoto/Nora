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

use Nora\Container\Container;


/**
 * フォーム
 */
class Form
{
	private $_request;
	private $_elements_container;
	private $_messages = array();
	private $_error_messages = array();


	public function __construct(  )
	{
		$this->_elements_container = new Container();
	}

	public function setRequest( $request )
	{
		$this->_request = $request;
	}

	/*
	public function isSubmit( )
	{
		if( $this->_request->isPost())
		{
			return true;
		}
	}
	 */

	public function addText( $name, $label )
	{
		$element = new Element\Text( $name, $label );
		return $this->appendChild( $name, $element );
	}

	public function addCheckbox( $name, $label )
	{
		$element = new Element\Checkbox( $name, $label );
		return $this->appendChild( $name, $element );
	}

	public function appendChild( $name, $element )
	{
		$element->setParent( $this );
		$this->_elements_container->$name = $element;
	}

	public function takeDefaultValue( $name )
	{
		return $this->_request->$name;
	}

	public function __get( $name )
	{
		return $this->_elements_container->$name;
	}

	public function takeValues( )
	{
		$values = array();
		foreach( $this->_elements_container as $k=>$e )
		{
			$values[$k] = $e->takeValue();
		}
		return $values;
	}

	public function appendErrorMessage( $msg )
	{
		$this->_error_messages[] = $msg;
	}

	public function appendMessage( $msg )
	{
		$this->_messages[] = $msg;
	}

	public function hasErrorMessage( )
	{
		return empty($this->_error_messages) ? false: true;
	}

	public function makeErrorMessage( $format = '%s<br />')
	{
		$formated_message = "";
		foreach( $this->_error_messages as $message )
		{
			$formated_message .= sprintf( $format, $message );
		}
		return $formated_message;
	}

	public function makeMessage( $format = '%s<br />')
	{
		$formated_message = "";
		foreach( $this->_messages as $message )
		{
			$formated_message .= sprintf( $format, $message );
		}
		return $formated_message;
	}

}
