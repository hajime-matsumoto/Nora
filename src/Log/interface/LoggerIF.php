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

use Nora\General;
use Nora\Log\Writer;

interface LoggerIF extends General\SingletonIF
{
    public function register();
    public function flush();
    public static function phpErrorHandlerAdapter( $errno, $errstr, $errfile, $errline );
    public function convPHPErrorNo( $errno, &$level, &$label );
    public function atachLogWriter( Writer\WriterIF $writer );
    public function write( $level, $label, $message );
}
