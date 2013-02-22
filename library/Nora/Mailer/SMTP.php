<?php
namespace Nora\Mailer;

use ArrayObject;
use Nora\DI;
use Nora\Network;

class SMTP implements DI\ComponentObjectIF
{
	use DI\ComponentObject;
	private $_host = 'localhost';
	private $_port = 587;
	private $_use_tls = false;
	private $_auth_user, $_auth_passwd;
	private $_default_header, $_default_footer;

	public function init( )
	{
	}

	public function factory( )
	{
		return $this;
	}

	public function setHost( $host )
	{
		$this->_host = $host;
		return $this;
	}

	public function setPort( $port )
	{
		$this->_port = $port;
		return $this;
	}

	public function useTLS( $bool )
	{
		$this->_use_tls = $bool ? true: false;
		return $this;
	}

	public function setAuth( $user, $passwd )
	{
		$this->_auth_user = $user;
		$this->_auth_passwd = $passwd;
		return $this;
	}

	public function setHeader( $header )
	{
		$this->_default_header = $header;
		return $this;
	}

	public function setFooter( $footer )
	{
		$this->_default_footer = $footer;
		return $this;
	}

	public function send( $mail )
	{
		$socket = new Network\Socket( $this->_host, $this->_port );
		$socket->connect();
		$socket->parseResponse('220');
		$socket->writeLine('EHLO '.$this->_host);
		$socket->parseResponse('250');
		$socket->writeLine('AUTH LOGIN');
		$socket->parseResponse('334');
		$socket->writeLine(base64_encode($this->_auth_user));
		$socket->parseResponse('334');
		$socket->writeLine(base64_encode($this->_auth_passwd));
		$socket->parseResponse('235');
		$socket->writeLine('MAIL FROM: <%s>', $this->_auth_user);
		$socket->parseResponse('250');
		foreach( $mail->getRecipients() as $recipient )
		{
			$socket->writeLine('RCPT TO: <%s>', $recipient);
			$socket->parseResponse('250');
		}
		$socket->writeLine('DATA');
		$socket->parseResponse('354');
		// ヘッダースタート
		$socket->writeLine('Content-Type: '.$mail->getContentType());
		$socket->writeLine('To: '.$mail->encodedTo());
		$socket->writeLine('From: '.$mail->encodedFrom());
		$socket->writeLine('Return-Path: '.$mail->encodedFrom());
		$socket->writeLine('Subject: '.$mail->encodedSubject());
		// 本文スタート
		$socket->writeLine();
		$socket->writeLine($mail->encode($this->_default_header));
		$socket->writeLine($mail->encodedBody());
		$socket->writeLine($mail->encode($this->_default_footer));
		$socket->writeLine('.');
		$socket->parseResponse('250');
	}
}
