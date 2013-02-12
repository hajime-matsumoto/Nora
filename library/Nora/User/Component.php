<?php
namespace Nora\User;
use Nora\DI;

/**
 * ユーザーコンポーネント
 */
class Component extends DI\Component implements DI\ComponentIF
{
	use DI\Containable;

	public function factory( )
	{
		return $this;
	}

	public function configAuthComponent( $value )
	{
		$this->addComponent('auth', $value['class'], $value['config'] );
	}
	public function configSessionComponent( $value )
	{
		$this->addComponent('session', $value['class'], $value['config'] );
	}
}
