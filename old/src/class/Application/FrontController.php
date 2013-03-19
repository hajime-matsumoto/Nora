<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Application
 * @package    Application
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Application;

use Nora\Base\DI;
use Nora\Config;
use Nora\Event;

/**
 * フロントコントローラー
 */
class FrontController extends \ArrayObject implements DI\ComponentIF
{
    use DI\ComponentTrait;
    use Event\ObserverTrait;
    use Event\ManagerOwnerTrait;

    protected $controllerPath;

    public function initialize( )
    {
        $this->getEventManager()->addEventObserver( $this );

        // イベント
        $this->addEventHandler('pre-dispatch', array($this,'eventControllerPreDispatch'));
        $this->addEventHandler('post-dispatch', array($this,'eventControllerPostDispatch'));
    }

    public function eventControllerPostDispatch( $e, $args )
    {
        if( !isset($args['controller']) ) return;

        $controller = $args['controller'];
        $response   = $controller->getResponse();
    }

    public function eventControllerPreDispatch( $e, $args )
    {
        if( !isset($args['controller']) ) return;

        $controller = $args['controller'];
        $uri_params = isset($args['uri_params']) ? $args['uri_params']: array();

        $request    = clone $this->pullComponent('request');
        foreach( $uri_params as $k=>$v )
        {
            $request[$k] = $v;
        }
        $response   = clone $this->pullComponent('response');

        $controller->setRequest( $request );
        $controller->setResponse( $response );
    }

    public function dispatch( $params = array() )
    {
        if( isset( $params['module'] ) )
        {
            $module = $params['module'];
            unset($params['module']);

            return $this->pullComponent('modules')->$module->bootstrap('frontController')->dispatch($params);
        }

        if( !isset( $params['controller'] ) ) return;
        if( !isset( $params['action'] ) ) return;

        $controller = $params['controller'];
        unset($params['controller']);
        $action = $params['action'];
        unset($params['action']);

        // コントローラを取得する
        $controller = $this->pullController( $controller );

        $this->getEventManager( )->trigger('pre-dispatch', array('controller'=>$controller, 'uri_params'=>$params) );

        // コントローラをディスパッチする
        $controller->dispatch( $action, $params );

        $this->getEventManager( )->trigger('post-dispatch', array('controller'=>$controller, 'uri_params'=>$params) );

        return $controller->getResponse();
    }

    public function pullController( $name )
    {
        if( isset($this[$name]) ) return $this[$name];


        $namespace = $this->pullComponent('config')->getConfig('class.namespace');
        $class = $namespace.'\\Controller\\'.ucfirst($name).'Controller';
        $controller = nora_class_new_instance( $class );

        // Eventを監視する
        $controller->getEventManager( )->addEventObserver( $this );
        $controller->setContainer( $this->getContainer() );
        $controller->setName( $name );

        return $this[$name] = $controller;
    }
}
