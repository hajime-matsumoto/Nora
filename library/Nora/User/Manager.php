<?php
namespace Nora\User;
use Nora\DI;

/**
 * ユーザマネージャー
 */
class Manager 
{
	private $_auth,$_session;

	public function __construct( $auth, $session )
	{
		$this->_auth = $auth;
		$this->_session = $session;
	}
}

