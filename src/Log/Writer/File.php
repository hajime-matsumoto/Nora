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
namespace Nora\Log\Writer;

use Nora\General;
use Nora\Log;
use Nora\Formatter;

class File implements WriterIF
{
    use WriterTrait;

    protected $logFileFormat = "/tmp/nora_log_%date%";
    protected $logFileOpenMode = "a";

    public function getLogFileName()
    {
        $formatter = new Formatter\Simple();
        $formatter->setup('keyStart','%')->setup('keyEnd','%');
        return $file = $formatter->format($this->logFileFormat, array('date'=>date('ymd')));
    }


    protected function _flush( $logs  )
    {
        $file = $this->getLogFileName();
        $fp = fopen($file, $this->logFileOpenMode);
        flock($fp,LOCK_EX);
        fwrite( $fp, "---- start ----\n");
        fwrite( $fp, implode("\n", $logs ));
        fwrite( $fp, "\n");
        flock($fp,LOCK_UN);
        fclose($fp);
    }
}
