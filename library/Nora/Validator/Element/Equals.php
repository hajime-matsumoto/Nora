<?php
namespace Nora\Validator\Element;
use ReflectionClass;

class Equals extends Element
{
	private $_expect;

	public function __construct( $expect )
	{
		$this->_expect = $expect;
	}
	protected function _validate( )
	{
		$value = $this->getBindValue();
		return $value == $this->_expect ? true: false;
	}
}
