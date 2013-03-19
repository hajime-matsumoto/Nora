<?php
// PHP Unitのオートローダーを有効にする
require_once 'PHPUnit/Autoload.php';

class NoraMailMailTestCase extends PHPUnit_Framework_TestCase
{
	public function testComposeMail( )
	{
		$mail = Nora\Mail\Mail::factory(
			$to = 'はじめ <hajime.matsumoto@gmail.com>',
			$from = 'まつもと <mail@hazime.org>',
			$subject = '送信テストだよ',
			$body = 'とどくかい。みえるかい',
			$headers = array('Return-Path: mail@hazime.org')
		);
		$this->assertInstanceOf('Nora\mail\mail', $mail);

		$this->assertNotNull($mail->toString());
		$this->assertEquals('1',count($mail->getRecipients()));
		$this->assertEquals('mail@hazime.org',$mail->getFrom());
	}

	public function testSendMail( )
	{
		nora( )->getContainer( )->addComponent('logger','Nora\Logging\Logger');

		$mail = Nora\Mail\Mail::factory(
			$to = 'はじめ <hajime.matsumoto@gmail.com>',
			$from = 'まつもと <mail@hazime.org>',
			$subject = '送信テストだよ',
			$body = 'とどくかい。みえるかい',
			$headers = array('Return-Path: mail@hazime.org')
		);

		//$smtp = new Nora\Mail\SMTP('tls://smtp.gmail.com', 465, 'hajime@avap.co.jp','bopdtvqfrcvymxmg',new Nora\Logging\Logger());
		//$smtp->send( $mail );
	}

	public function testTemplateMail( )
	{
		nora( )->getContainer( )->addComponent('logger','Nora\Logging\Logger');

		$mail_templator = new Nora\Mail\Templator( );
		$mail_templator->setTemplateFile(NORA_HOME.'/doc/examples/templator/templates/mail/info.tpl');
		$mail_templator->toString();

		//$smtp = new Nora\Mail\SMTP('tls://smtp.gmail.com', 465, 'hajime@avap.co.jp','bopdtvqfrcvymxmg',new Nora\Logging\Logger());
		//$smtp->send( $mail_templator );
	}

	public function testComponentMail( )
	{
		nora( )->getContainer( )->addComponent('logging','Nora\Logging\Logger');
		nora( )->getContainer( )->addComponent('mailer','Nora\Mail\Mailer',array(
			'smtp'=>array('host'=>'tls://smtp.gmail.com','port'=>465,'user'=>'hajime@avap.co.jp','passwd'=>'bopdtvqfrcvymxmg')
		));

		$mail = nora_component('mailer')->templateMail(NORA_HOME.'/doc/examples/templator/templates/mail/info.tpl');
		//nora_component('mailer')->smtpSend( $mail );
	}
}
