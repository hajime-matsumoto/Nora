<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 * のらライブラリを使用する場合
 * 必ず、このスクリプトをインクルードする
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

// 定数の定義
//-------------------------------
if(!defined('NORA_HOME'))
{
	// このスクリプトから1階層上のディレクトリを設定
	define('NORA_HOME', realpath( dirname(__FILE__).'/..' ) );
}

// PHPの設定
//-------------------------------

// インクルードパスを追加
ini_set( 'include_path', ini_get( 'include_path' ) .':'.NORA_HOME.'/library' );

// のらインスタンスを作成
//-------------------------------
require_once 'Nora/Core/Nora.php';
$nora = Nora\Core\Nora::getInstance( );


// クラスのオートローディングを設定する
//--------------------------------

// ライブラリローダーを作成
require_once 'Nora/Core/LibraryLoader.php';
$loader = new Nora\Core\LibraryLoader( );

// ローダーにパスを追加する
$loader->addSearchPath( NORA_HOME .'/library' );
// $loder->addSearchPath([ディレクトリパス],[クラスプレフィックス])

// ローダーをAutoLoaderとして登録する
spl_autoload_register( array($loader,'autoLoad') );

// ローダーをNoraに登録する
$nora->setLibraryLoader( $loader );







