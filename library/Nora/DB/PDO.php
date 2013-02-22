<?php
/**
 * のらライブラリ
 */
namespace Nora\DB;

use Nora;


/**
 * Database Controller
 */
class PDO extends DB
{
	private $_PDO;
	public function __construct( $dsn, $user, $pass )
	{
		$this->_PDO = new \PDO( $dsn, $user, $pass );
		$this->debug('Connected : %s', $dsn);
	}

	public function sendQuery( $sql )
	{
		$this->debug('sendQuery: %s', $sql);
		$result = $this->_PDO->query( $sql );

		$statement = new Statement( );
		$statement->setResult( $result );
		$statement->setHandler( $this );

		return $statement;
	}

	public function fetchColumn( $result )
	{
		return $result->fetchColumn( );
	}

	public function fetch( $result )
	{
		return $result->fetch( \PDO::FETCH_ASSOC );
	}

	public function prepare( $sql )
	{
		return $this->_PDO->prepare( $sql );
	}

}
