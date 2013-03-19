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
namespace Nora\Service;


/**
 * これを実装していれば、マネージャー生成時に
 * initialize( Manager )する
 */
interface InitializableIF
{
    /**
     * 初期化する
     */
    public function serviceInitialize( ManagerIF $manager, $setting = array() );

    /**
     * 初期化したか
     */
    public function isServiceInitialized( );

    /**
     * 初期化した事を通知
     */
    public function serviceInitialized( );
}
