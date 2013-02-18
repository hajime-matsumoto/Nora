<?php
namespace Nora\Session;
use Nora\DI;

/**
 * SESSIONコンポーネント
 */
class Component implements DI\ComponentObjectIF
{
	use DI\ComponentObject;

	public function init() 
	{
	}

	public function factory( )
	{
		// メソッド
		$manager = new Manager();
		$manager->setMethod( new Method\File() );
		return $manager;
	}
}
