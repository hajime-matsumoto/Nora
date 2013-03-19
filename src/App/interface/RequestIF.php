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
namespace Nora\App;

/**
 * リクエストインターフェイス
 */
interface RequestIF extends \ArrayAccess
{
    /**
     * 一括で値を設定する
     */
    public function setVars( $datas );

    /**
     * 値を設定する
     */
    public function setVar( $name, $value );
}
