<?php
require_once '../src/bootstrap.php';

// アプリケーション定数
define('APP_HOME',NORA_HOME.'/doc/examples/application');
define('APP_ENV', getenv('APP_ENV') ? getenv('APP_ENV'): 'product' );

// アプリケーションをセットアップ
nora( )->getContainer( )->addComponent(
	'application',
	'Nora\Application\Application',
	array(
		'config'=>APP_HOME.'/config/application.ini',
		'env'=>APP_ENV
	)
);

ini_set('display_errors', 1);

$app = nora_component('application');
$app->run( );
?>
