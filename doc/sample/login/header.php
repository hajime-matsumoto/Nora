<?php
require_once '/opt/nora/include/header.php';

// ライブラリにパスを追加
// ===========================
Nora()->libraryLoader->addSearchPath(dirname(__FILE__).'/library');

// このサイト用のブートストラッパを設定
Nora()->bootstrapper->loadResourceArray(
	array(
		'request'=>new Nora\Request\Web()
		,'login' => array(
			'class' => '\Modules\Login'
		)
	)
);

//var_dump(NoraBootstrap('app')->callHistory());

