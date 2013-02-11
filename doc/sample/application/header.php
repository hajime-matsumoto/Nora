<?php
require_once '/opt/nora/include/header.php';
ini_set('display_errors','On');
use Nora\Core\Nora;

// ライブラリにパスを追加
// ===========================
Nora::init();

// 共通要素を定義
// ===========================
Nora::getInstance()->configComponent(
	'logger',
	array(
		'type'=>'file',
		'config'=>array(
			'log_file_path'=>'/tmp/nora-log-www',
			'log_file_mode'=>'w'
		)
	)
);

// 固有要素
// ===========================
Nora::getInstance()->libraryLoader->addSearchPath(dirname(__FILE__).'/library');

// このサイト用のブートストラッパを設定
// ===========================
Nora::getInstance()->bootstrap->loadResourceArray(
	array(
		'asterisk'=>array(
			'class' => 'Nora\Asterisk\Component',
			'config'=>array(
				'host'=>'phone.hazime.org',
				'port'=>5038,
				'username'=>'www',
				'secret'=>'deganjue'
			)
		),
		'db'=>array(
			'class'=>'Nora\DB\Component',
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
		),
		'view'=>array(
			'class'=>'Nora\View\Component',
			'config'=>array(
				'viewDir'=>dirname(__FILE__).'/view'
			)
		)
	)
);

Nora::getInstance()->bootstrap->view->headMeta()->setCharset('utf-8');
Nora::getInstance()->bootstrap->view->headTitle('のらサンプルアプリケーション');
Nora::getInstance()->bootstrap->view->headStyle('label { display:block; }');

