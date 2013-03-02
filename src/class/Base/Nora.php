<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 * Noraクラスファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Base;

use Nora\Base\DI;

/**
 * のらクラス
 */
class Nora implements DI\ContainerOwnerIF
{
    use DI\ContainerOwnerTrait;

    /**
     * シングルトンインスタンスを保持
     */
    static private $_instance;

    /**
     * シングルトンで使用する場合
     */
    static public function getInstance( )
    {
        if( static::$_instance ) return static::$_instance;

        static::$_instance = new static;
        return static::$_instance;
    }
}
