<?php
namespace Nora\Session;
use Nora\DI;

/**
 * SESSIONコンポーネント
 */
class Component extends DI\Component implements DI\ComponentIF
{
	public function factory( )
	{
		// メソッド
		$manager = new Manager();
		$manager->setMethod( new Method\File() );
		return $manager;
	}
}
