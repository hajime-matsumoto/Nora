<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 * テストファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, nora project all rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正bsdライセンス
 * @version    $id$
 */

namespace Nora\Mail;

use Nora\Service;
use Nora\General;
use Nora\General\Helper;

/**
 * メーラー
 */
class Mailer
{
    use General\SetupableTrait;
    use Helper\HelperTrait;

    protected $smtpHost;
    protected $smtpPort;
    protected $smtpUser;
    protected $smtpPassword;
    protected $smtpFrom;

    public function __construct( $setup_options = array() )
    {
        $this->setup($setup_options);
    }

    public function Mailer()
    {
        return $this;
    }

    public function send( $recipt, $subject, $body, $headers )
    {
        //$mail = new Mail( );
        //$mail->setup(compact('recipt','subject','body','headers'));

        $smtp = new SMTP();
        $smtp->connect($this->smtpHost,$this->smtpPort);
        $smtp->auth($this->smtpUser,$this->smtpPassword);
        $smtp->from($this->smtpFrom);
        $smtp->recipt($recipt);
        $smtp->dataStart();
        $smtp->writeLine('Subject: ', $subject);
        $smtp->writeLine('From: info@avap.co.jp');
        $smtp->writeLine('To: mail@hazime.org');
        $smtp->writeLine('');
        $smtp->writeLine($body);
        $smtp->dataEnd();

    }



}
