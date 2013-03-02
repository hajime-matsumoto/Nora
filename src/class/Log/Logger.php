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
namespace Nora\Log;

use Nora\Base\DI;

/**
 * ファイルベースロガー
 */
class Logger implements LoggerIF,DI\ComponentIF
{
    use LoggerTrait,DI\ComponentTrait;

    /**
     * ログレベルの定数化
     */
    const E_DEBUG   = 1;
    const E_NOTICE  = 2;
    const E_WARNING = 4;
    const E_ERROR   = 8;
    const E_ALL     = 15;


    protected function loggingReal( $message )
    {
        echo $message."\n";
    }
}
