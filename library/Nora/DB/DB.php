<?php
/**
 * のらライブラリ
 */
namespace Nora\DB;

use Nora;
use Nora\Logger\Logging;
use Exception;


/**
 * Database Controller
 */
class DB
{
	use Logging;

	// DB::connect( $type, $dsn, $user, $pass )
	static public function connect( $dsn, $user, $pass )
	{
		$type = strtok($dsn,':');
		$rc = new \ReflectionClass( __NAMESPACE__.'\\'.ucfirst($type) );
		return $rc->newInstanceArgs( func_get_args() );
	}

	public function query( $sql )
	{
		return $this->sendQuery( $sql );
	}
}
