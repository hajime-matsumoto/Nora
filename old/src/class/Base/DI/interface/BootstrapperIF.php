<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @category   Base
 * @package    DI
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Base\DI;

/**
 * ブートストラッパインターフェイス
 */
interface BootstrapperIF extends ContainerIF
{
    /**
     * _initメソッドをコンポーネントとして登録する
     */
    public function bootstrapperInitialize();

    /**
     * コンポーネントの設定値を変えてファクトリを登録し直す
     */
    public function resourceInitialize( $resources_setting );

    /**
     * ブートストラップを拡張したクラス用の初期化メソッド
     */
    public function initialize( );
}
