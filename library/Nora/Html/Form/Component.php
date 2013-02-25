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
			$this[$name] = new Form(  );
		}
		return $this[$name];
	}
}
