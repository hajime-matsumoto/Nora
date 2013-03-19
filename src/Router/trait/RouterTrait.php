<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Router;

use Nora\Request;

/**
 * ルーター機能
 */
trait RouterTrait
{
    private $_request;
    private $_routes = array();

    public function __construct( )
    {
        $this->addRoute('990-default','/:controller/:action/:params');
        $this->addRoute('999-default','/:controller/:action');
    }

    /**
     * リクエストを設定する
     */
    public function setRequest( Request\RequestIF $request )
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * ルートを追加する
     */
    public function addRoute( $name, $pattern, $defaults = array() )
    {
        // パターンを変換する
        $pattern = $this->_convertPattern( $pattern, $params );
        $this->_routes[$name] = array('pattern'=>$pattern,'params'=>$params,'defaults'=>$defaults);
        return $this;
    }

    private function _convertPattern( $pattern, &$params )
    {
        return preg_replace(
            '/\:([a-zA-Z0-9-_]+)/e',
            '$this->_replaceParams("\1", $params);',
            $pattern 
        );
    }

    private function _replaceParams( $name, &$params )
    {
        $params[] = $name;
        return "(.+)";
    }

    /**
     * ルートを実行する
     */
    public function routing( Request\RequestIF $request = null)
    {
        if( $request != null ) $this->setRequest( $request );
        $params = $this->_routing( $request );
        foreach( $params as $k=>$v )
        {
            if( $k == 'module' )
            {
                $this->_request->setParam('module_name', $v);
            }elseif( $k =='controller' ){
                $this->_request->setParam('controller_name', $v );
            }elseif( $k =='action' ){
                $this->_request->setParam('action_name', $v );
            }
            $this->_request[$k] = $v;
        }
        return $this->_request;
    }

    private function _routing( $request )
    {
        $uri = $request->getParam('request_uri');
        ksort($this->_routes);

        foreach($this->_routes as $route )
        {
            $regex = $route['pattern'];


            if( preg_match('%'.$regex.'%', $uri, $m ) )
            {
                array_shift($m);

                // 結果にキーを与える
                $dict = array_combine( $route['params'], $m );

                // 初期値を上書き
                return array_merge($route['defaults'],$dict);
            }
        }

    }
}
