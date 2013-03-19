<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\General\Bootstrap;

/**
 * ブートストラッパインターフェイス
 */
interface BootstrapperIF
{
    /**
     * ブートストラップリソースを追加する
     */
    public function addBootstrapResource( $name, $factory );

    /**
     * 初期化する
     */
    public function bootstrap( $name );
}
