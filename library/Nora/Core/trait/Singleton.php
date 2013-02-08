<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Core;

// シングルトンパターン
trait Singleton
{
	static private $_my_instance;

	static public function getInstance( )
	{
		if(self::$_my_instance)
		{
			return self::$_my_instance;
		}

		return self::$_my_instance = new static();
	}

	static public function resetInstance( )
	{
		self::$_my_instance = false;
	}
}
