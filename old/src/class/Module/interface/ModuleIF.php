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
 * モジュールインターフェイス
 */
interface ModuleIF
{
    /**
     * モジュールを作成する
     */
    static public function factory( $module_name,$module_directory );

    /**
     * モジュール名をセットする
     */
    public function setName( $name );

    /**
     * モジュールのネームスペースをセットする
     */
    public function setNamespace( $namespace );

    /**
     * モジュールのディレクトリをセットする
     */
    public function setDirectory( $directory );

    /**
     * 初期化
     */
    public function initialize( );

    /**
     * コンフィグをセットする
     */
    public function setConfig( $config_file, $env );

    /**
     * コンフィグを取得する
     */
    public function getConfig( );

    /**
     * モジュールのクラスを作成
     */
    public function newInstance( $class );
}
