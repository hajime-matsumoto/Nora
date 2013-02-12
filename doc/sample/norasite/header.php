<?php
require_once '/opt/nora/library/Nora/Core/Nora.php';

use Nora\Core\Nora;

//
// PHPの設定
// ===========================
ini_set('display_errors', 'On');

//
// のらを初期化
// ===========================
Nora::init();

//
// 定数を定義
// ===========================

// ルートを定義
if( !defined('APP_ROOT') )
{
	define('APP_ROOT', dirname(__FILE__) );
}

//
// 共通コンポーネントを定義
// ===========================

// ライブラリローダにパスを追加
Nora::getInstance()->libraryLoader->addSearchPath( APP_ROOT.'/library' );

// ロガーの設定
Nora::getInstance()->configComponent(
	'logger',
	array(
		'type'=>'file',
		'config'=>array(
			'log_file_path'=> APP_ROOT.'/log/nora.log',
			'log_file_mode'=>'w'
		)
	)
);

//
// オリジナルのブートストラップを適用
// =============================
Nora::getInstance()->addComponent('bootstrap', 'NoraSite\Bootstrap');















