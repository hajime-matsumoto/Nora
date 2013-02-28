<?php
namespace Nora\Mailer;

use ArrayObject;
use Nora\DI;
use Nora\Network;

class SMTP 
{
	private $_ques;

	private $_host,$_port,$_user,$_passwd;

	public function __construct( )
	{
	}

	public function setup( $host, $port, $user, $passwd )
	{
		$this->_host = $host;
		$this->_port = $port;
		$this->_user = $user;
		$this->_passwd = $passwd;
	}

	public function sendQue( $mail )
	{
		$this->_ques[] = $mail->toQue();
	}

	public function runQue( )
	{
		$command = sprintf('php -f %s/command/send.php', dirname(__FILE__));
		foreach( $this->_ques as $que )
		{
			$recipients = implode(',',$que['recipients']);
			$from = $que['from'];
			$mail = escapeshellarg($que['mail']);

			$query = escapeshellarg(sprintf(
				'host=%s;port=%s;user=%s;passwd=%s;recipient=%s;from=%s;',
				$this->_host,
				$this->_port,
				$this->_user,
				$this->_passwd,
				$recipients,
				$from
			));

			exec(
				sprintf(
					'%s %s %s > /dev/null &',
					$command,
					$query,
					$mail
				)
			);
		}
	}


	public function executeSendQue( )
	{
		foreach( $this->_ques as $que )
		{
			$this->sendMail( $que['recipients'],$que['from'],$que['mail'] );
		}
	}

	public function sendMail( $recipients, $from, $mail )
	{
		$socket = new Network\Socket( $this->_host, $this->_port );
		$socket->connect();
		$socket->parseResponse('220');
		$socket->writeLine('EHLO '.$this->_host);
		$socket->parseResponse('250');
		$socket->writeLine('AUTH LOGIN');
		$socket->parseResponse('334');
		$socket->writeLine(base64_encode($this->_user));
		$socket->parseResponse('334');
		$socket->writeLine(base64_encode($this->_passwd));
		$socket->parseResponse('235');
		$socket->writeLine('MAIL FROM: <%s>', $from);
		$socket->parseResponse('250');
		foreach( $recipients as $recipient )
		{
			$socket->writeLine('RCPT TO: <%s>', $recipient);
			$socket->parseResponse('250');
		}
		$socket->writeLine('DATA');
		$socket->parseResponse('354');
		$socket->writeLine($mail);
		$socket->writeLine('.');
		$socket->parseResponse('250');
	}

	public function __destruct( )
	{
		$this->runQue();
	}
}
/*
class SMTP implements DI\ComponentObjectIF
{
	use DI\ComponentObject;
	private $_host = 'localhost';
	private $_port = 587;
	private $_use_tls = false;
	private $_auth_user, $_auth_passwd;
	private $_default_header, $_default_footer;
	private $_mails = array();

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
		$data = base64_encode(serialize( array(
			'host'=>$this->_host,
			'port'=>$this->_port,
			'user'=>$this->_auth_user,
			'passwd'=>$this->_auth_passwd,
			'header'=>$this->_default_header,
			'footer'=>$this->_default_footer,
			'mails'=>array($mail)
		)));
		exec( 'php -f '.dirname(__FILE__).'/command/send.php '.$data.'  > /dev/null & ');
	}

	public function sendSync( $mail )
	{
		$this->_send( $mail );
	}



	public function _send( $mail )
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
 */
