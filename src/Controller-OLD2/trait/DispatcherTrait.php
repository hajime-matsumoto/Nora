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

use Nora\General;

/**
 * コントローラディスパッチャ
 */
trait DispatcherTrait
{
    use General\ParamHolderTrait,General\SetupableTrait;

    protected $front;
    protected $defaultModuleName;
    protected $defaultControllerName;
    protected $defaultActionName;
    protected $request;
    protected $response;

    /**
     * コントローラをディスパッチする
     */
    public function dispatch( )
    {
        // ディスパッチ対象を検索する
        $module_name     = $this->request->getParam('module_name', $this->defaultModuleName);
        $controller_name = $this->request->getParam('controller_name', $this->defaultControllerName);

        $controller = $this->front->pullController( $module_name, $controller_name );
        $controller->setup('request', $this->request);
        $controller->setup('response', $this->response);
        $controller->setup('actionName', $this->request->getParam('action_name', $this->defaultActionName));
        $controller->dispatch( );

        $this->_last_request = $this->request;

        return $this->response;
    }

    /**
     * ラストリクエスト
     */
    public function getLastRequest( )
    {
        return $this->_last_request;
    }



    /**
     * ディスパッチループ用
     */
    public function hasNext( )
    {
        if( $this->response->hasParam('nextRequest') ) {
            $this->request = $this->response->getParam('nextRequest');
            $this->response->delParam('nextRequest');
            return true;
        }
        return false;
    }
}
