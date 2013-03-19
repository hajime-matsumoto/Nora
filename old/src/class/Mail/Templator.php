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
use Nora\Template;

/**
 * メールテンプレータ
 */
class Templator extends Mail implements Template\TemplatorIF
{
    use Template\TemplatorTrait;

    public function toString( )
    {
        $datas = $this->render();
        $this->loadString($datas);
        return parent::toString();
    }

    public function loadString( $datas )
    {
        $isHeader = true;
        $body = '';
        foreach( explode(PHP_EOL,$datas) as $line )
        {
            if( $isHeader ){
                if( empty($line) ){
                    $isHeader = false;
                    continue;
                }
                $key = strtok( $line, ':');
                if($key == 'To') {
                    $this->setTo(trim(strtok('')));
                }elseif( $key == 'Cc'){
                    $this->setCc( trim(strtok('')));
                }elseif( $key == 'Subject'){
                    $this->setSubject( trim(strtok('')));
                }elseif( $key == 'From' ){
                    $this->setFrom( trim(strtok('')));
                }

            }else{
                $body .= $line.PHP_EOL;
            }
        }
        $this->setBody( $body );
    }
}
