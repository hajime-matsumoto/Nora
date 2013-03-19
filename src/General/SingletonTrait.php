<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * オートローダクラスを定義する
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\General;


/**
 * シングルトン機能
 */
trait SingletonTrait
{
    /** シングルトンインスタンス */
    static private $_instance;

    /** シングルトン */
    static public function getInstance( )
    {
        if( static::$_instance ) return static::$_instance;
        return static::$_instance = new static;
    }
}
