<?php
/**
 * のらライブラリ
 */
namespace Nora\DB;

use Nora;


/**
 * Database Controller
 */
class Statement extends DB
{
	private $_PDO;
	public function __construct( $dsn, $user, $pass )
	{
		$this->_PDO = new \PDO( $dsn, $user, $pass );
	}

	public function query( $sql )
	{
		$connection = $this->_PDO
		return $this->_PDO->query( $sql );
	}
}
