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

/**
 * シングルトンパターン
 *
 * シングルトンパターンを実装する為のトレイト
 *
 * @author Hajime MATUMOTO <mail@hazime.org>
 */
trait Singleton
{
	static private $_my_instance;

	/**
	 * シングルトンインスタンスを取得
	 * 
	 * @return instance
	 */
	static public function getInstance( )
	{
		if(self::$_my_instance)
		{
			return self::$_my_instance;
		}

		return self::$_my_instance = new static();
	}

	/**
	 * シングルトンインスタンスを破棄
	 */
	static public function resetInstance( )
	{
		self::$_my_instance = false;
	}
}
