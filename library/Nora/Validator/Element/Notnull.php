<?php
namespace Nora\Validator\Element;
use ReflectionClass;

class Notnull extends Element
{
	protected function _validate( )
	{
		$value = $this->getBindValue();
		return empty($value) ? false: true;
	}
}
