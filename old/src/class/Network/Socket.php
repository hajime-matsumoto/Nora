<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Network;

use Nora\Logging;

/**
 * ソケット I/O
 */
class Socket
{
    use Logging\LoggingTrait;

    private $_socket;

    public function __construct( $host, $port , $logger = null)
    {
        if( $logger ) $this->setLogger($logger);

        if( !$this->_socket = fsockopen($host,$port,$errno,$errstr,1) )
        {
            return false;
        }
        $this->debug( 'Connected: %s:%s', $host, $port );
    }

    /**
     * コネクションを切断 
     */
    public function disconnect( )
    {
        fclose($this->_socket);
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
        $this->debug( 'Resp:'.$line );
        return $line;
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
        $this->debug( 'Sent: %s', trim($text)."\r\n");
        fputs( $this->_socket, trim($text)."\r\n");
    }

    /**
     * 全てのレスポンスを読み出す 
     */
    public function getResponse( )
    {
        $resp = "";
        while($line = $this->readLine())
        {
            $resp.=$line;
        }
        return $resp;
    }

    /**
     * レスポンスを読み,解析する 
     */
    public function parseResponse( $expect )
    {
        $response="";

        while(substr($response,3,1) != " "){
            if( !$response = $this->readLine( ) )
            {
                $this->error("サーバーからのレスポンスコードを取得出来ませんでした。");
                return;
            }
        }

        if(!(substr($response,0,3) == $expect)){
            $this->error(
                "送信出来ませんでした。".
                "SMTPサーバーから次のエラーコードが報告されています。"
                .$response
            );
        }

        return $response;
    }
}
