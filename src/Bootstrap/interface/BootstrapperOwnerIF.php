<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 * テストファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, nora project all rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正bsdライセンス
 * @version    $id$
 */

namespace Nora\Bootstrap;

/**
 * ブートストラップオーナーインターフェイス
 */
interface BootstrapperOwnerIF 
{
    /**
     * ブートストラッパをセットする
     */
    public function setBootstrapper( BootstrapperIF $bootstrapper );

    /**
     * ブートストラッパを取得する
     */
    public function getBootstrapper( );

    /**
     * ブートストラッパがあるか
     */
    public function hasBootstrapper( );

    /**
     * ブートストラップリソースを取得
     */
    public function bootstrap( $name = null );

}

