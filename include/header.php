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
ini_set( 'include_path', ini_get( 'include_path' ) .':'.NORA_HOME );

// のらインスタンスを作成
//-------------------------------
require_once 'library/core/nora.php';
$nora = Nora\Core\Nora::getInstance( );


// クラスのオートローディングを設定する
//--------------------------------

// ライブラリローダーを作成
require_once 'library/core/libraryLoader.php';
$loader = new Nora\Core\LibraryLoader( );

//
// ローダーにパスを追加する
//$loder->addSearchPath([ディレクトリパス],[クラスプレフィックス])

// Zime\\から始まるクラスはルートのライブラリディレクトリを検索する
$loader->addSearchPath( NORA_HOME .'/library', 'Nora\\' );

// ローダーをZimeに登録する
$nora->setLibraryLoader( $lader );





