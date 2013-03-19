<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Controller
 * @package    Front
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Controller;

use Nora\Base\DI;
use Nora\Event;
use Nora\General;
use Nora\Module;

/**
 * コントローラー
 */
trait FrontTrait 
{
    use DI\ComponentTrait;
    use Event\ManagerOwnerTrait;
    use General\ParamHolderTrait;
    use Module\BrokerTrait;

    static private $_instance;

    protected $request       = 'Nora\Controller\Request';
    protected $response      = 'Nora\Controller\Response';
    protected $router        = 'Nora\Controller\Router';
    protected $dispatcher    = 'Nora\Controller\Dispatcher';
    protected $view_renderer = 'Nora\Controller\ViewRenderer';

    static public function getInstance( )
    {
        if( self::$_instance ) return self::$_instance;
        return new static;
    }

    /**
     * リクエストをセット
     */
    public function setRequest( $request )
    {
        $this->request = $request;
    }

    /**
     * リクエストを取得
     */
    public function getRequest( )
    {
        return nora_class_create_if_string( $this->request );
    }

    /**
     * ルーターをセット
     */
    public function setRouter( $router )
    {
        $this->router = $router;
    }

    /**
     * ルーターを取得
     */
    public function getRouter( )
    {
        return nora_class_create_if_string( $this->router );
    }

    /**
     * レスポンスをセット
     */
    public function setResponse( $response )
    {
        $this->response = $response;
    }

    /**
     * レスポンスを取得
     */
    public function getResponse( )
    {
        return nora_class_create_if_string( $this->response );
    }

    /**
     * ディスパッチをセット
     */
    public function setDispatcher( $dispatcher )
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * ディスパッチを取得
     */
    public function getDispatcher( )
    {
        return nora_class_create_if_string( $this->dispatcher );
    }

    /**
     * ビューをセット
     */
    public function setViewRenderer( $view_renderer )
    {
        $this->view_renderer = $view_renderer;
    }

    /**
     * ビューを取得
     */
    public function getViewRenderer( )
    {
        return nora_class_create_if_string( $this->view_renderer, array(), function($o){ $o->setFront($this); } );
    }

    /**
     * 起動
     */
    public function dispatch( )
    {
        $this->_routing( );

        $this->getEventManager( )->trigger('pre-dispatch-loop', $this->getDispatcher(), $this );

        $this->_dispatch( );

        $this->getEventManager( )->trigger('post-dispatch-loop', $this->getDispatcher( ), $this );
    }

    protected function _dispatch( )
    {
        $this->getEventManager( )->trigger('pre-dispatch', $this);

        $this->getDispatcher( )->setRequest ( $this->getRequest()  );
        $this->getDispatcher( )->setResponse( $this->getResponse() );
        $this->getDispatcher( )->setParams  ( $this->getParams()   );
        $this->getDispatcher( )->setFront  ( $this );
        $this->getDispatcher( )->dispatch( );

        $this->getEventManager( )->trigger('post-dispatch', $this);
    }

    protected function _routing( )
    {
        $this->getEventManager( )->trigger('pre-routing', $this);
        $this->getRouter( )->setRequest( $this->getRequest( ) )->routing( );
        $this->getEventManager( )->trigger('post-routing', $this);
    }
}


