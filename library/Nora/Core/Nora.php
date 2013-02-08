<?php
/**
 * のらライブラリ 
 *
 * @author Hajime MATUMOTO <mail@hazime.org>
 */

namespace Nora\Core;

require_once 'Nora/Core/trait/Singleton.php';


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

	private $_library_loader;


	/**
	 * ライブラリローダーを保持
	 */
	public function setLibraryLoader( LibraryLoader $loader )
	{
		$this->_library_loader = $loader;
	}

	/**
	 * ライブラリローダーを取得
	 *
	 * @return LibraryLoader
	 */
	public function getLibraryLoader( )
	{
		return $this->_library_loader;
	}
}

