<?php
require_once '/opt/nora/include/header.php';

// ライブラリにパスを追加
// ===========================
Nora()->libraryLoader->addSearchPath(dirname(__FILE__).'/library');

// このサイト用のブートストラッパを設定
Nora()->bootstrapper->loadResourceArray(
	array(
		'jumper'=>array(
			'class' => 'Useful\Jumper'
		)
	)
);


// ジャンパーを取得
$jumper = NoraBootstrap('jumper');

// ジャンパーのリクエスト先を設定
$jumper->addUrl('http://www.google.com');
$jumper->addUrl('http://www.yahoo.co.jp');
$jumper->addUrl('http://amazon.co.jp');
