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

use Nora\General;

class Mail
{
    use General\AutoProp;

    // メールヘッダーの初期値を定義
    private $_headers = array(
        array('name'=>'MIME-Version','value'=>'1.0'),
        array('name'=>'Content-Type','value'=>'text/plain','options'=>array('charset'=>'utf8')),
        array('name'=>'Content-Transfer-Encoding','value'=>'base64'),
        array('name'=>'Content-Disposition','value'=>'inline'),
        array('name'=>'X-MAILER-APP','value'=>'Nora Mail')
    );

    protected $recipient = array();
    protected $from = '';
    protected $subject = '';
    protected $head = '';
    protected $body = '';
    protected $foot = '';

    public function resetHeaders()
    {
        $this->_headers = array(
            array('name'=>'MIME-Version','value'=>'1.0'),
            array('name'=>'Content-Type','value'=>'text/plain','options'=>array('charset'=>'utf8')),
            array('name'=>'Content-Transfer-Encoding','value'=>'base64'),
            array('name'=>'Content-Disposition','value'=>'inline'),
            array('name'=>'X-MAILER-APP','value'=>'Nora Mail')
        );
    }

    static public function factory( $to, $from, $subject, $body, $headers = array())
    {
        $mail = new Mail();
        $mail->setTo( $to );
        $mail->setFrom( $from );
        $mail->setSubject( $subject );
        $mail->setBody( $body );
        foreach( $headers as $header )
        {
            $mail->addHeaderWithParse( $header );
        }
        return $mail;
    }


    public function setFrom( $from )
    {
        $this->addHeader('From',$this->encodeMailAddress($from));
        $this->setFromWithParse( $from );
    }

    public function setTo( $to )
    {
        $this->addHeader('To',$this->encodeMailAddress($to));
        $this->addRecipientWithParse( $to );
    }
    public function setCc( $to )
    {
        $this->addHeader('Cc',$this->encodeMailAddress($to));
        $this->addRecipientWithParse( $to );
    }
    public function setBcc( $to )
    {
        $this->addRecipientWithParse( $to );
    }

    public function setSubject( $subject )
    {
        $this->addHeader('Subject', mb_encode_mimeheader( $subject ) );
    }

    public function addHeader( $name, $value=null, $options=array() )
    {
        if( $value == null ) return $this->addHeaderWithParse( $name );

        // 複数宣言許可されていないヘッダーであれば削除する
        if( !in_array($name, array('To','Cc') ) )
        {
            $this->removeHeader($name);
        }

        $this->_headers[] = array('name'=>$name, 'value'=>$value, 'options'=>$options );
    }

    public function removeHeader( $name )
    {
        foreach( $this->_headers as $k=>$v )
        {
            if( $v['name'] == $name ) unset($this->_headers[$k]);
        }
    }

    public function addHeaderWithParse( $string )
    {
        $name = strtok($string,':');
        $value = strtok(';');
        $options = array();
        while( $part = strtok(';') )
        {
            list($k,$v) = explode('=',$part);
            $options[$k] = $v;
        }
        $this->addHeader( $name, $value, $options );
    }

    public function addRecipientWithParse( $string )
    {
        if( !preg_match('/<([^>]+)>/', $string, $m) ) return $this->addRecipient($string);
        return $this->addRecipient( $m[1] );
    }

    public function setFromWithParse( $string )
    {
        if( !preg_match('/<([^>]+)>/', $string, $m) ) return $this->from = $string;
        return $this->from = $m[1];
    }

    private function encodeMailAddress( $address )
    {
        if( !preg_match('/([^\s]*)\s*<([^>]+)>/', $address, $m ) ) return $address;
        if( '' === trim($m[1]) ) $m[1] = trim($m[2]);
        return mb_encode_mimeheader( $m[1] )." <{$m[2]}>" ;
    }


    protected function formatHeaders( $headers )
    {
        if( !is_array($headers) ) return;

        $formated_headers  = array();
        foreach( $headers as $v )
        {
            $formated_headers[] = $this->formatHeader( $v );
        }
        return implode(PHP_EOL, $formated_headers);
    }

    protected function formatHeader( $header )
    {
        if(!is_array($header)) return $header;

        $formated_header = sprintf('%s: %s', $header['name'],$header['value']);

        if(isset($header['options']) && is_array($header['options']))
        {
            foreach( $header['options'] as $kk=>$vv )
            {
                $formated_header.=sprintf("; %s=%s", $kk,$vv);
            }
        }
        return $formated_header;
    }

    public function toString( )
    {
        $text = '';
        $text.= implode(',',$this->recipient);
        $text.=$this->formatHeaders( $this->_headers ).PHP_EOL;
        $text.= PHP_EOL;
        $text.= base64_encode($this->head.PHP_EOL.$this->body.PHP_EOL.$this->foot).PHP_EOL;
        return $text;
    }

    public function getRecipients( )
    {
        return array_unique($this->recipient);
    }
}
