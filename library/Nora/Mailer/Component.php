<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Mailer;
use Nora\DI;

/**
 * データベース接続コンポーネント
 */
class Component extends Mailer implements DI\ComponentObjectIF,DI\ContainerObjectIF
{
	use DI\ComponentObject;
	use DI\ContainerObject;

	public function init( )
	{
		$this->addComponent('smtp','Nora\Mailer\SMTP');
		$this->addComponent('parser','Nora\Mailer\MailParser');
	}

	public function getSmtp( )
	{
		return $this->component('smtp');
	}

	public function newMail( $file )
	{
		$mail =  MailParser::parseFile( $file );
		$mail->setMailer( $this );
		return $mail;
	}

	public function factory( )
	{
		return $this;
	}
}
