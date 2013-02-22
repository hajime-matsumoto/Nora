<?php
namespace Nora\Mailer;

class Mailer
{
	public $smtp;

	public function setSMTP( SMTP $smtp )
	{
		$this->smtp = $smtp;
	}

	public function send( $mail )
	{
		$this->smtp->send( $mail );
	}

	public function newMail( )
	{
		return new Mail( );
	}
}
