<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Logging;


/**
 * ファイルベースロガー
 */
class FileLogger extends Logger
{
    protected $file = '/tmp/a';
    protected $mode = 'a';

    private $_fp;

    public function initialize( )
    {
        $this->loggingStart();
    }

    public function __destruct( )
    {
        $this->loggingEnd( );
    }

    public function loggingStart( )
    {
        $this->_fp = fopen($this->file,$this->mode);
        flock( $this->_fp, LOCK_EX );
        $this->writeLine('------------ロギング開始-----------');
    }

    public function loggingEnd( )
    {
        $this->writeLine('------------ロギング終了-----------');
        flock( $this->_fp, LOCK_UN );
        fclose($this->_fp);
    }

    protected function loggingReal( $message )
    {
        $this->writeLine( $message );
    }

    protected function writeLine( $message )
    {
        fwrite( $this->_fp, $message.PHP_EOL );
    }
}
