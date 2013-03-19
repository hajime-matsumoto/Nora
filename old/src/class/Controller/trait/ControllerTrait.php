<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Controller
 * @package    Controller
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */

namespace Nora\Controller;

/**
 * コントローラー機能
 */
trait ControllerTrait
{
    private $_module;
    /**
     * モジュールをセットする
     */
    public function setModule( $module )
    {
        $this->_module = $module;
    }

    /**
     * モジュールを取得する
     */
    public function getModule( )
    {
        return $this->_module;
    }

    /**
     * 名前をセットする
     */
    public function setName( $name )
    {
        $this->_name = $name;
    }

    /**
     * アクションを初期化する
     */
    public function init( )
    {
    }

    /**
     * アクションを実行する
     */
    public function run( $action_name, $request = null, $response = null)
    {
        if( method_exists( $this, $method = $action_name.'Action' ) )
        {
            return call_user_func( array($this,$method), $request, $response );
        }
        die(' Action Not Found '.$action_name );
    }
}
