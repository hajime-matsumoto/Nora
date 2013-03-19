<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Controller
 * @package    Request
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Controller;

/**
 * リクエストインターフェイス
 */
interface RequestIF
{
    /**
     * モジュール名を設定
     */
    public function setModuleName( $module_name );

    /**
     * コントローラ名を設定
     */
    public function setControllerName( $controller_name );

    /**
     * アクション名を設定
     */
    public function setActionName( $action_name );

    /**
     * リクエストURIを設定
     */
    public function setURI( $uri );

    /**
     * モジュール名を取得
     */
    public function getModuleName( );

    /**
     * コントローラ名を取得
     */
    public function getControllerName( );

    /**
     * アクション名を取得
     */
    public function getActionName( );

    /**
     * リクエストURIを取得
     */
    public function getURI( );

}
