<?php
require_once '/opt/nora/include/header.php';

// ライブラリにパスを追加
// ===========================
Nora()->libraryLoader->addSearchPath(dirname(__FILE__).'/library');

// このサイト用のブートストラッパを設定
Nora()->bootstrapper->loadResourceArray(
	array(
		'asterisk'=>array(
			'class' => 'NoraResource\Asterisk',
			'config'=>array(
				'host'=>'phone.hazime.org',
				'port'=>5038,
				'username'=>'www',
				'secret'=>'deganjue'
			)
		),
		'db'=>array(
			'class'=>'NoraResource\DB',
			'config'=>array(
				'type'=>'mysql',
				'dbname'=>'asterisk',
				'dbhost'=>'db.hazime.org',
				'dbport'=>3306,
				'dbuser'=>'asterisk',
				'dbpassword'=>'deganjue'
			)
		),
		'app'=>array(
			'class'=>'Sample\App'
		)
	)
);

//var_dump(NoraBootstrap('app')->callHistory());

