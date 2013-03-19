<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Mail
 * @package    Mail
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Mail;

use Nora\Base\DI;

/**
 * メーラーコンポーネント
 */
class Mailer implements DI\ComponentIF
{
	use DI\ComponentTrait;

	protected $smtp;

	public function initialize( )
	{
	}

	public function templateMail( $file )
	{
		$mail = new Templator();
		$mail->setTemplateFile( $file );
		return $mail;
	}

	public function smtpSend( $mail )
    {
		$smtp = $this->smtp;
		$smtp = new SMTP($smtp['host'],$smtp['port'],$smtp['user'],$smtp['passwd'],$this->pullComponent('logging'));
		$smtp->send( $mail );
	}

}
