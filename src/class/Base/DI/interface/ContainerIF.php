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
 * コンテナーインターフェイス
 */
interface ContainerIF extends ContainerOwnerIF
{
    /**
     * コンポーネントを削除
     */
    public function removeComponent( $name );

    /**
     * コンポーネントを追加
     */
    public function addComponent( $name, $factory, $setting = array());

    /**
     * コンポーネントを取得する
     */
    public function pullComponent( $name );

    /**
     * コンポーネントの設定値を取得する
     */
    public function getComponentSetting( $name );

    /**
     * コンポーネントが存在するか
     */
    public function hasComponent( $name );
}
