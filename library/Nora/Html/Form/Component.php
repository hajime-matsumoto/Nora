<?php
namespace Nora\Html\Form;
use Nora\DI;
use ArrayObject;

/**
 * Formコンポーネント
 */
class Component extends ArrayObject implements DI\ComponentObjectIF
{
	use DI\ComponentObject;
	private $_my_forms = array();

	public function init( )
	{
	}

	public function factory( )
	{
		return $this;
	}

	public function form( $name )
	{
		if(!isset($this[$name]))
		{
			$this[$name] = new Form( $name);
		}
		return $this[$name];
	}
}
