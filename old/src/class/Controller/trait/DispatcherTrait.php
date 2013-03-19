<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Controller
 * @package    Dispatcher
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Controller;

use Nora\General;

/**
 * ディスパッチャー
 */
trait DispatcherTrait
{
    use General\ParamHolderTrait;

    protected $request    = null;
    protected $response   = null;
    protected $front;

    /**
     * フロントを設定
     */
    public function setFront( $front )
    {
        $this->front = $front;
    }


    /**
     * リクエストをセット
     */
    public function setRequest( $request )
    {
        $this->request = $request;
    }

    /**
     * レスポンスをセット
     */
    public function setResponse( $response )
    {
        $this->response = $response;
    }

    /**
     * リクエストを取得
     */
    public function getRequest( )
    {
        return $this->request;
    }

    /**
     * レスポンスを取得
     */
    public function getResponse( )
    {
        return $this->response;
    }

    /**
     * 起動
     */
    public function dispatch( $request=null, $response=null)
    {
        $request    = $request==null ? $this->request: $request;
        $response   = $response==null ? $this->response: $response;

        $module_name     = $request->getModuleName();
        $controller_name = $request->getControllerName();
        $action_name     = $request->getActionName();

        if( $this->front->hasModule($module_name) )
        {
            $module = $this->front->getModule( $module_name );
        }

        $controller = $module->newInstance('Controller\\'.ucfirst($controller_name));
        $controller->setModule( $module );
        $controller->setName( $controller_name );
        $status = $controller->run( $action_name, $request, $response );

        if( $status ) $response->setStatus( $status );

        // 実行してレスポンスを返す
        return $response;
    }
}


