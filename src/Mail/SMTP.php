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

class SMTP
{
    private $_socket;
    private $_logs=array();

    public function __construct( )
    {
    }

    public function __destruct()
    {
        fclose($this->_socket);
    }

    /**
     * 通信ログを取得
     */
    public function getLogs()
    {
        return $this->_log;
    }

    /**
     * SMTPサーバ接続
     */
    public function connect( $host, $port )
    {
        if( !$this->_socket = fsockopen($host,$port,$errno,$errstr,1) ) throw new SMTPConnectionException("Errorno[$errno] $errstr");
        $this->parseResponse('220');
        $this->writeLine('EHLO '.$host);
        $this->parseResponse('250');
    }

    /**
     * SMTP認証
     */
    public function auth( $user, $passwd )
    {
        $this->writeLine('AUTH LOGIN');
        $this->parseResponse('334');
        $this->writeLine(base64_encode($user));
        $this->parseResponse('334');
        $this->writeLine(base64_encode($passwd));
        $this->parseResponse('235');
    }

    /**
     * 送信者追加
     */
    public function from( $mail_address )
    {
        $this->writeLine('MAIL FROM: <%s>', $mail_address);
        $this->parseResponse('250');
    }

    /**
     * 宛先追加
     */
    public function recipt( $mail_address )
    {
        $this->writeLine('RCPT TO: <%s>', $mail_address);
        $this->parseResponse('250');
    }

    /**
     * データ開始
     */
    public function dataStart( )
    {
        $this->writeLine('DATA');
        $this->parseResponse('354');
    }

    /**
     * データ終了
     */
    public function dataEnd()
    {
        $this->writeLine('.');
        $this->parseResponse('250');
    }

    /**
     * １行書き込む
     */
    public function writeLine( $text = null )
    {
        if(func_num_args() > 1 )
        {
            return $this->writeLine(vsprintf($text,array_slice(func_get_args(),1)));
        }
        $this->_log[] = sprintf('Sent: %s', trim($text)."\r\n");
        fputs( $this->_socket, trim($text)."\r\n");
    }
    /**
     * １行読み込む
     */
    public function readLine( )
    {
        if(feof($this->_socket)){
            return false;
        }
        $line = fgets($this->_socket);

        $this->_log[] = 'Resp:'.$line;
        return $line;
    }

    /**
     * レスポンスを読み,解析する
     */
    public function parseResponse( $expect )
    {
        $response="";

        while(substr($response,3,1) != " "){
            if( !$response = $this->readLine( ) ) throw new SMTPException("サーバーからのレスポンスコードを取得出来ませんでした。");
        }

        if(!(substr($response,0,3) == $expect)) throw new SMTPException(
            "送信出来ませんでした。".
            "SMTPサーバーから次のエラーコードが報告されています。"
            .$response
            .print_r($this->_log,true)
        );

        return $response;
    }
}

class SMTPException extends \Exception {}
