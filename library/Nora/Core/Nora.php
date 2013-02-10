<?php
/**
 * のらライブラリ 
 *
 * @author Hajime MATUMOTO <mail@hazime.org>
 */

namespace Nora\Core;



/**
 * のらライブラリのルートクラス
 *
 * 機能
 *
 * - ライブラリローダーの保持
 * - メインブートストラップの保持
 * - コンテナの保持
 *
 * @author Hajime MATUMOTO <mail@hazime.org>
 */
class Nora
{
	use Singleton;

	/** DIコンテナ */
	private $_container;

	public function __construct()
	{
		$this->_container = new \Nora\DI\Container();
	}


	/**
	 * ライブラリローダーを保持
	 */
	public function setLibraryLoader( LibraryLoader $loader )
	{
		$this->_container->addService("library.loader", $loader);
	}

	/**
	 * ライブラリローダーを取得
	 *
	 * @return LibraryLoader
	 */
	public function getLibraryLoader( )
	{
		return $this->_container->service("library.loader");
	}
}

