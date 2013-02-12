<?php
namespace Nora\Session\Method;

abstract class Method implements MethodIF
{
	public function getSecret( )
	{
		return "CHANGE ME NORA";
	}

	public function genSessionKey( )
	{
		return sha1( uniqid( mt_rand() , true ) . $this->getSecret() );
	}

	abstract public function checkSessionKey( $session_key );
	abstract public function registerSessionKey( $session_key );
	abstract public function saveSessionData( $session_key, $session_data );
	abstract public function restroreSessionData( $session_key );
}
