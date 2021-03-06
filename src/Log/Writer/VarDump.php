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

class VarDump implements WriterIF
{
    use WriterTrait;

    public function _flush($logs)
    {
        var_dump($logs);
    }
}
