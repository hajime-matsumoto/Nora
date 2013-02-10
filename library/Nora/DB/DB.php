<?php
/**
 * のらライブラリ
 */
namespace Nora\DB;

use Nora;
use Exception;


/**
 * Database Controller
 */
class DB
{
	// DB::connect( $type, $dsn, $user, $pass )
	static public function connect( $type )
	{
		$rc = new \ReflectionClass( __NAMESPACE__.'\\'.$type );
		return $rc->newInstanceArgs( array_slice(func_get_args(),1) );
	}

	public function query( $sql )
	{
		return $this->sendQuery( $sql );
	}
}