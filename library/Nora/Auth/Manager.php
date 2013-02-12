<?php
namespace Nora\Auth;

use Nora\DI;

/**
 * セッションマネージャー
 *
 * セッションキーの保持方法をクッキーにするかゲットにするか悩む
 *
 */
class Manager 
{
	private $_method;

	public function setMethod( $method )
	{
		$this->_method = $method;
	}

	public function getMethod( )
	{
		return $this->_method;
	}

	public function auth( $user, $passwd )
	{
		return $this->_method->auth( $user, $passwd );
	}
}
