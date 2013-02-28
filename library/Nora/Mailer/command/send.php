<?php
$dir   = dirname($argv[0]);
$query = $argv[1];
$mail  = $argv[2];

require_once realpath($dir.'/../../Core/Nora.php');

mb_language("japanese");
mb_internal_encoding("UTF8");

Nora\Core\Nora::init();
//Nora\Core\Nora::getInstance()->addComponent('logger','Nora\Logger\Component');

// ロガーの設定
Nora\Core\Nora::getInstance()->addComponent(
	'logger',
	'Nora\Logger\Component',
	array(
		'type'=>'file',
		'config'=>array(
			'log_file_path'=> '/tmp/nora-mail.log',
			'log_file_mode'=>'a'
		)
	)
);


$smtp = new Nora\Mailer\SMTP( );

$data = strtok($query,';');
$params = array();
while( $data )
{
	list($k,$v) = explode('=', $data, 2);
	$params[$k] = $v;
	$data = strtok(';');
}

$smtp->setUp( $params['host'], $params['port'], $params['user'], $params['passwd'] );

$smtp->sendMail( explode(',',$params['recipient']), $params['from'], $mail);
?>
