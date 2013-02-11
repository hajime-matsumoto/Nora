<?php
namespace Nora\DI;

class Callback
{
	private $_invoke;

	public function __construct( )
	{
		if( func_num_args( ) == 2 )
		{
			$class = func_get_arg(0);
			$method = func_get_arg(1);

			$this->_invoke = function()use($class,$method){
				return call_user_func(array($class,$method));
			};
		}
	}

	public function __invoke()
	{
		$func = $this->_invoke;
		return $func();
	}
}
