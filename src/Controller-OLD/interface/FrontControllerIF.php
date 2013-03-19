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
namespace Nora\Controller;

use Nora\Response;
use Nora\Request;

/**
 * フロントコントローラインターフェイス
 */
interface FrontControllerIF extends ControllerIF
{
    /**
     * ルーターをセットする
     */
    public function setRouter( $_router );

    /**
     * ルーターを取得する
     */
    public function getRouter( );

    /**
     * アプリケーションをセットする
     */
    public function setApp( $module, $directory = null );

    /**
     * モジュールネームスペース
     */
    public function setModuleNamespace( $module, $namespace = null );

    /**
     * モジュールネームスペースを取得する
     */
    public function getModuleNamespace( $module = null );

    /**
     * コントローラディレクトリを設定する
     */
    public function setControllerDir( $module, $directory = null );

    /**
     * コントローラディレクトリを取得する
     */
    public function getControllerDir( $module = null );

    /**
     * アクションをディスパッチする
     */
    public function dispatch( Response\ResponseIF $response = null, Request\RequestIF $request = null);
}
