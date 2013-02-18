<?php
/**
 * のらライブラリ 
 *
 * @author Hajime MATUMOTO <mail@hazime.org>
 */

namespace Nora\Core;

// 定数の定義
//-------------------------------
if(!defined('NORA_HOME'))
{
	define('NORA_HOME', realpath( dirname(__FILE__).'/../../../' ) );
}

// PHPの設定
//-------------------------------
// インクルードパスを追加
ini_set( 'include_path', ini_get( 'include_path' ) .':'.NORA_HOME.'/library' );


// 依存関係にあるクラスを読み込む
//-------------------------------
require_once 'Nora/Core/trait/Singleton.php';
require_once 'Nora/Loader/LibraryLoader.php';
require_once 'Nora/DI/interface/ContainerObjectIF.php';
require_once 'Nora/DI/trait/ContainerObject.php';

use Nora\DI;
use Nora\Loader\LibraryLoader;

/**
 * のらライブラリのルートクラス
 *
 * 機能
 *
 * - DIコンテナの保持
 *
 * @author Hajime MATUMOTO <mail@hazime.org>
 */
class Nora implements DI\ContainerObjectIF
{
	use Singleton;
	use DI\ContainerObject;

	private function __construct()
	{
		return false;
	}

	static public function init( )
	{
		$loader = new LibraryLoader( );
		$loader->addSearchPath( NORA_HOME.'/library' );
		$loader->register();
		static::getInstance()->addComponent('libraryLoader', $loader );
		static::getInstance()->addComponent('bootstrap', 'Nora\Bootstrap\Bootstrapper');
	}
}

