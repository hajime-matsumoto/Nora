<?php
namespace Nora\Helper;

trait HelperObject
{
	public function __invoke( )
	{
		$class = get_class($this);
		if($pos = strrpos($class,'\\'))
		{
			$class = substr($class,$pos+1);
		}
		return call_user_func_array( array($this, $class), func_get_args() );
	}

}
