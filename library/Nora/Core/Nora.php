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
	// このスクリプトから1階層上のディレクトリを設定
	define('NORA_HOME', realpath( dirname(__FILE__).'/../../../' ) );
}

// PHPの設定
//-------------------------------
// インクルードパスを追加
ini_set( 'include_path', ini_get( 'include_path' ) .':'.NORA_HOME.'/library' );


// 依存関係にあるクラスを読み込む
//-------------------------------
require_once 'Nora/Core/trait/Singleton.php';
require_once 'Nora/Core/LibraryLoader.php';
require_once 'Nora/DI/Container.php';

/**
 * のらライブラリのルートクラス
 *
 * 機能
 *
 * - DIコンテナの保持
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
		$this->_di_container = new \Nora\DI\Container();
		$this->setUp();
	}

	/** セットアップする */
	public function setUp()
	{
		$this->getContainer()->addService('libraryLoader',new LibraryLoader( ));
		// ライブラリへのパス
		$this->getContainer()->libraryLoader->addSearchPath( NORA_HOME .'/library' );
		// ローダーを登録する
		$this->getContainer()->libraryLoader->register( );

		// ブートローダを設定
		$this->getContainer( )->addService('bootstrapper', function( ){
			return new \Nora\Bootstrap\Bootstrapper( );
		});
	}

	/** DIコンテナを取得 */
	public function getContainer( )
	{
		return $this->_di_container;
	}

	public function hasService( $name )
	{
		return $this->_di_container->hasService( $name );
	}

	public function service( $name )
	{
		return $this->_di_container->service( $name );
	}

	public function __get( $name )
	{
		return $this->service($name);
	}

}

