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

use Nora\Base\DI;

/**
 * ロギング可能インターフェイス
 */
interface LoggingIF
{
    public function setLogger( $logger );
    public function getLogger( );
    public function debug( $msg );
    public function notice( $msg );
    public function warn( $msg );
    public function error( $msg);
}
