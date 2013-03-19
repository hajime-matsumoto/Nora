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
 * リクエストの機能
 */
trait RequestTrait
{
    private $_module_name;
    private $_controller_name;
    private $_action_name;
    private $_uri;

    /**
     * モジュール名を設定
     */
    public function setModuleName( $module_name )
    {
        $this->_module_name = $module_name;
    }

    /**
     * コントローラ名を設定
     */
    public function setControllerName( $controller_name )
    {
        $this->_controller_name = $controller_name;
    }

    /**
     * アクション名を設定
     */
    public function setActionName( $action_name )
    {
        $this->_action_name = $action_name;
    }

    /**
     * リクエストURIを設定
     */
    public function setURI( $uri )
    {
        $this->_uri = $uri;
    }


    /**
     * モジュール名を取得
     */
    public function getModuleName( )
    {
        return $this->_module_name;
    }

    /**
     * コントローラ名を取得
     */
    public function getControllerName( )
    {
        return $this->_controller_name;
    }

    /**
     * アクション名を取得
     */
    public function getActionName( )
    {
        return $this->_action_name;
    }

    /**
     * リクエストURIを取得
     */
    public function getURI( )
    {
        return $this->_uri;
    }
}
