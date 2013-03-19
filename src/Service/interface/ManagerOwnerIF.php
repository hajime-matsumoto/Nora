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
 * サービスマネージャーオーナーインターフェイス
 */
interface ManagerOwnerIF
{
    /**
     * 親マネージャーをセットする
     */
    public function setServiceManager( ManagerIF $manager );

    /**
     * 親マネージャを取得する
     */
    public function getServiceManager( );

    /**
     * 親マネージャがあるか？
     */
    public function hasServiceManager( );
}
