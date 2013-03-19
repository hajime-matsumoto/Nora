<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Module
 * @package    Module
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Module;

/**
 * モジュールブローカーIF
 */
interface BrokerIF
{
    /**
     * モジュールを取得する
     */
    public function getModules( );

    /**
     * モジュールを取得する
     */
    public function getModule( $module_name );

    /**
     * モジュールディレクトリを取得する
     */

    /**
     * モジュールが存在するか？
     */
    public function hasModule( $module_name );

    /**
     * デフォルトモジュールを追加
     *
     * @param ネームスペース
     * @param ディレクトリ
     */
    public function setDefaultModule( $module_directory );

    /**
     * モジュールを追加
     *
     * @param 名前
     * @param ネームスペース
     * @param ディレクトリ
     */
    public function addModule( $module_name, $module_directory );

    /**
     * モジュールディレクトリを追加
     */
    public function addModulesDir( $dirname );
}


