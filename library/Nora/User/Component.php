<?php
namespace Nora\User;
use Nora\DI;

/**
 * ユーザーコンポーネント
 */
class Component implements DI\ComponentObjectIF
{
	use DI\ComponentObject;

	private $_auth, $_session;

	public function init( )
	{
		// AuthとSessionを使う
		if( !$auth = $this->findComponent('auth') )
		{
			throw new DI\ComponentNotFound( 'Authコンポーネントが見つかりません' );
		}

		if( !$session = $this->findComponent('session') )
		{
			throw new DI\ComponentNotFound('セッションコンポーネントが見つかりません');
		}
		$this->_auth = $auth;
		$this->_session = $session;
	}

	public function factory( )
	{
		return new Manager( $this->_auth, $this->_session );
	}
}
