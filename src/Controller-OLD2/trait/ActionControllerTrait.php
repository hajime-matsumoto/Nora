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
use Nora\Request;

/**
 * アクションコントローラ
 */
trait ActionControllerTrait
{
    use General\SetupableTrait;
    use General\ParamHolderTrait;
    use General\Helper\BrokerOwnerTrait;

    protected $request;
    protected $response;
    protected $router;
    protected $dispatcher;
    protected $front;
    protected $actionName;
    protected $controllerName;

    public function dispatch( )
    {
        if(method_exists($this,$method=$this->actionName.'Action'))
        {
            call_user_func(array($this,$method), $this->request, $this->response);
            return $this->response;
        }

        // アクションが見つからなかった時
        // NotFoundErrorに転送する
        $this->forward( 'notFound', 'error', null,array(
            'notFoundAction'=> sprintf('%s:%s', $this->controllerName, $this->actionName)
        ));

        return $this->response;
    }

    /**
     * 別のコントローラに転送する
     */
    public function forward( $action_name, $controller_name = null, $module_name = null, $params = array() )
    {
        if( $controller_name == null ) $controller_name = $this->controllerName;

        // リクエストを作成する
        $request = new Request\Request( );
        $request->setParam('action_name'     , $action_name);
        $request->setParam('controller_name' , $controller_name);
        $request->setParam('module_name'     , $module_name);
        $request->setVars( $params );

        $this->response->setParam('nextRequest', $request );
    }
}
