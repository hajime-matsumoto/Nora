<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Mail
 * @package    SMTP
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Mail;

use Nora\Network;
 
class SMTP extends Network\Socket
{
	public function __construct( $host, $port, $user = null, $passwd = null, $logger = null)
    {
		parent::__construct( $host, $port, $logger );

		$this->parseResponse('220');
		$this->writeLine('EHLO '.$host);
		$this->parseResponse('250');

		if( $user == null ) return;

		$this->writeLine('AUTH LOGIN');
		$this->parseResponse('334');
		$this->writeLine(base64_encode($user));
		$this->parseResponse('334');
		$this->writeLine(base64_encode($passwd));
		$this->parseResponse('235');
    }

    public function send( $mail )
    {
        $mail_data = $mail->toString();
        $recipients = $mail->getRecipients();
        $from = $mail->getFrom();

		$this->writeLine('MAIL FROM: <%s>', $from);
		$this->parseResponse('250');
		foreach( $recipients as $recipient )
		{
			$this->writeLine('RCPT TO: <%s>', $recipient);
			$this->parseResponse('250');
		}
		$this->writeLine('DATA');
        $this->parseResponse('354');
        $this->writeLine( $mail_data );
		$this->writeLine('.');
        $this->parseResponse('250');
    }
}
