<?php
namespace Nora\Validator;
use ReflectionClass;

class Validator 
{
	static function factory( $type )
	{
		return static::factory( $type, array_slice( func_get_args(), 1) );
	}

	static function factoryArray( $type, $args )
	{
		$rc = new ReflectionClass( __NAMESPACE__.'\\Element\\'.ucfirst($type) );
		return $rc->newInstanceArgs( $args );
	}

}


