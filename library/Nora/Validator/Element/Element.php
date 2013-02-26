<?php
namespace Nora\Validator\Element;
use ReflectionClass;

abstract class Element
{
	private $_binded_vars = array();
	private $_validators = array();

	public function bindValue( $value )
	{
		$this->bind('value', $value);
	}

	public function bind($key, $value)
	{
		$this->_binded_vars[$key] = $value;
	}

	public function getBindValue( )
	{
		return $this->getBind('value');
	}

	public function getBind($key)
	{
		$value = $this->_binded_vars[$key];
		if( $value instanceof \Closure )
		{
			return $value();
		}
		return $value;
	}

	public function validate( )
	{
		if( !$this->_validate() )
		{
			return false;
		}

		foreach($this->_validators as $validator )
		{
			if( !$validator->validate() )
			{
				return false;
			}
		}
		return true;
	}

	public function add( $validator )
	{
		$this->_validators[] = $validator;
	}
	abstract protected function _validate();
}
