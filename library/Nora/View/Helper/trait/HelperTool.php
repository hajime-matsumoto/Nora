<?php
namespace Nora\View\Helper;

trait HelperTool
{
	public function __invoke( )
	{
		$array = explode('\\', __CLASS__);
		$direct =  array_pop( $array );

		return call_user_func_array( array($this,$direct), func_get_args());
	}

	public function __toString( )
	{
		return $this->toString();
	}
}
