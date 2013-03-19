<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Controller
 * @package    Router
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Controller;

/**
 * ルーター機能
 */
trait RouterTrait
{
    private $_request;
    private $_routes;

    /**
     * リクエストを設定する
     */
    public function setRequest( RequestIF $request )
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
    public function routing( )
    {
        $params = $this->_routing( );
        foreach( $params as $k=>$v )
        {
            if( $k == 'module' )
            {
                $this->_request->setModuleName( $v );
            }elseif( $k =='controller' ){
                $this->_request->setControllerName( $v );
            }elseif( $k =='action' ){
                $this->_request->setActionName( $v );
            }
            $this->_request[$k] = $v;
        }
        return $this->_request;
    }

    private function _routing( )
    {
        $uri = $this->_request->getURI( );
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
