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
use Nora\Event;

/**
 * アプリケーションコントローラー基本機能
 */
trait ControllerTrait 
{
    use DI\ComponentTrait;
    use Event\ManagerOwnerTrait;

    private $_request;
    private $_response;
    private $_name;

    public function setName( $name )
    {
        $this->_name = $name;
    }

    public function getName( )
    {
        return $this->_name;
    }

    public function dispatch( $action_name, $params )
    {
        if( method_exists( $this, $method = 'action'.ucfirst($action_name) ) )
        {
            $this->getResponse( )->setActionName($action_name);
            $result = call_user_func( array($this, $method), $this->getRequest(), $this->getResponse() );
        }else{
            $result = $this->actionNotfound( $action_name, $params);
        }
        $this->getResponse( )->setControllerName($this->getName());
        $this->getResponse( )->setResult($result);
    }

    public function actionNotfound( $name )
    {
        die( '404 Action Not Fund ' . $name );
    }

    public function setRequest( $requst )
    {
        $this->_request = $requst;
    }

    public function setResponse( $response )
    {
        $this->_response = $response;
    }

    public function getRequest( )
    {
        return $this->_request;
    }

    public function getResponse( )
    {
        return $this->_response;
    }

    public function pullFront( )
    {
        return $this->getContainer()->pullComponent('FrontController');
    }

    public function pullConfig( )
    {
        return $this->getContainer()->pullComponent('Config');
    }

    public function pullBootstrapper( )
    {
        return $this->getContainer()->pullComponent('Bootstrapper');
    }

    public function bootstrap( $name )
    {
        return $this->getContainer( )->pullComponent('bootstrapper')->bootstrap( $name );
    }
}
