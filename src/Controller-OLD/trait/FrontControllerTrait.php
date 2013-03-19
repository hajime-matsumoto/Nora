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

use Nora\Router;
use Nora\Response;
use Nora\Request;
use Nora\App\App;
use Nora\Util\Util;

/**
 * フロントコントローラインターフェイス
 */
trait FrontControllerTrait
{
    use ControllerTrait;

    private $_controller_dirs    = array();
    private $_module_namespaces  = array();
    private $_default_module     = 'default';
    private $_default_controller = 'home';
    private $_default_action     = 'index';
    private $_router             = 'Nora\Router\Router';

    /**
     * ルーターをセットする
     */
    public function setRouter( $_router )
    {
        $this->_router = $_router;
    }

    /**
     * ルーターを取得する
     */
    public function getRouter( )
    {
        return $this->_router = Util::helper('object')->newInstanceFromString( $this->_router );
    }

    /**
     * アプリケーションをセットする
     */
    public function setApp( $module, $directory = null )
    {
        if( $directory == null ) return $this->setApp( $this->_default_module, $module);

        $app = new App( $module, $directory );
        $config = $app->bootstrap('config');
        $this->setModuleNamespace( $module, $config->getConf('namespace').'\\Controller' );
        $this->setControllerDir( $module,  $app->getDir().'/controller' );

    }

    /**
     * モジュールネームスペース
     */
    public function setModuleNamespace( $module, $namespace = null )
    {
        if( $namespace == null ) return $this->setModuleNamespace( $this->_default_module, $module);
        $this->_module_namespaces[$module] = $namespace;
        return $this;
    }

    /**
     * モジュールネームスペースを取得する
     */
    public function getModuleNamespace( $module = null )
    {
        if( $module == null ) $module = $this->_default_module;
        return $this->_module_namespaces[$module];
    }

    /**
     * コントローラディレクトリを設定する
     */
    public function setControllerDir( $module, $directory = null )
    {
        if( $directory == null ){
            if( !is_array($module ) ) {
                return $this->setControllerDir($this->_default_module, $module);
            }
            foreach( $module as $name=>$directory ){
                $this->setControllerDir($name, $directory);
            }
            return;
        }

        $this->_controller_dirs[$module] = $directory;
    }

    /**
     * コントローラディレクトリを取得する
     */
    public function getControllerDir( $module = null )
    {
        if( $module == null ) return $this->_controller_dirs;

        return $this->_controller_dirs[$module];
    }

    /**
     * アクションをディスパッチする
     */
    public function dispatch( Response\ResponseIF $response = null, Request\RequestIF $request = null)
    {
        if( $response == null ) $response = $this->getResponse();
        if( $request == null ) $request = $this->getRequest();

        // ルーティング
        $this->routing( $request );

        // アクションを実行する
        $module_name     = $request->getModuleName($this->_default_module);
        $controller_name = $request->getControllerName($this->_default_controller);
        $action_name     = $request->getActionName($this->_default_action);

        $response = $this
            ->getController( $module_name, $controller_name )
            ->runAction( $action_name, $response, $request );

        // アクションが終了したら、レスポンスパラメタにパラメタを渡す
        $response->setParam('module_name'     , $module_name);
        $response->setParam('controller_name' , $controller_name);
        $response->setParam('action_name'     , $action_name);

        return $response;
    }
    /**
     * リクエストをルーティングする
     */
    public function routing( Request\RequestIF $request = null)
    {
        $this->getRouter( )->routing( $request );
    }

    /**
     * コントローラを作成する
     */
    public function getController( $module_name, $controller_name = null )
    {
        if( $controller_name == null) return $this->getControllerDir( $this->_default_module, $module_name );

        // コントローラを取得する
        $dir       = $this->getControllerDir( $module_name );
        $file      = $dir.'/'.ucfirst($controller_name).'.php';
        $namespace = $this->getModuleNamespace( $module_name );
        $class     = $namespace.'\\'.ucfirst($controller_name);

        if( file_exists( $file ) )
        {
            include_once $file;
        }

        if(!class_exists($class)){
            throw new ControllerClassNotExists(sprintf('%s - %s', $class,$file));
        }

        $controller = new $class( );
        $controller->setFront( $this );
        $controller->setHelperBroker( $this->getHelperBroker() );
        return $controller;
    }
}

class ControllerClassNotExists extends \Exception{}
