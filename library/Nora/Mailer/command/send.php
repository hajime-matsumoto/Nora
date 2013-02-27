<?php
$dir = dirname($argv[0]);
require_once realpath($dir.'/../../Core/Nora.php');

mb_language("japanese");
mb_internal_encoding("UTF8");

Nora\Core\Nora::init();

$datas = unserialize(base64_decode($argv[1]));

$host = $datas['host'];
$port = $datas['port'];
$user = $datas['user'];
$passwd = $datas['passwd'];
$header = $datas['header'];
$footer = $datas['footer'];
$mails = $datas['mails'];
$data = $argv[1];

$mailer = new Nora\Mailer\Mailer;
$mailer->setSMTP(new Nora\Mailer\SMTP());
$mailer->smtp
	->setHost($host)
	->setPort($port)
	->setAuth($user,$passwd)
	->setHeader($header)
	->setFooter($footer);

foreach( $mails as $mail )
{
	$mail->language('japanese');
	$mailer->smtp->sendSync( $mail );
}
?>
