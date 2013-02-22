<?php
/*
 * のらテスト
 *---------------------- 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';


require_once dirname(__FILE__).'/../../../include/header.php';
use Nora\Core\Nora;

class FormTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		Nora::init();
		Nora::getInstance()
			->bootstrap
			->addComponent('mailer', 'Nora\Mailer\Component');
		$this->mailer = Nora::getInstance()->bootstrap->mailer;
	}

	public function testMailer( )
	{
		$this->mailer->smtp
				->setHost('tls://smtp.gmail.com')
				->setPort(465)
				->useTLS(true)
				->setAuth('hajime@avap.co.jp', 'bopdtvqfrcvymxmg' )
				->setHeader('このメールは自動送信メールです'.PHP_EOL)
				->setFooter("--\nSent From: mail@hazime.org\n");

		$this->mailer->send(
			$this->mailer->newMail( )
			->setLanguage('japanese')
			->setTo('hajime@avap.co.jp','ハジメ')
			->setFrom('mail@hazime.org','松本創')
			->setSubject('お知らせ')
			->setBody('本文')
		);

	}
	
}
