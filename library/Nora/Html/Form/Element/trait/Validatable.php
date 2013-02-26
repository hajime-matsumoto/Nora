<?php
namespace Nora\Html\Form\Element;

use Nora\Validator;

trait Validatable
{
	private $_validator = false;

	/**
	 * バリテーションを実行する
	 */
	public function validate( )
	{
		if( $this->_validator )
		{
			return $this->_validator->validate();
		}
		return null;
	}

	public function addValidator( $type )
	{
		$validator = Validator\Validator::factoryArray($type, array_slice(func_get_args(),1));
		$validator->bindValue(function(){ return $this->getValue();});
		if( $this->_validator )
		{
			$this->_validator->add( $validator );
		}
		else
		{
			$this->_validator = $validator;
		}
		return false;
	}

}

