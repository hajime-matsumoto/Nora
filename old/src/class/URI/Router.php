<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @category   URI
 * @package    URI
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\URI;

use Nora\Base\DI;

/**
 * URIルーター
 */
class Router implements DI\ComponentIF
{
    use DI\ComponentTrait;

    private $_route_list = array();

    /**
     * ルートパターンを設定する
     */
    public function addRoute( $num, $pattern, $default = array())
    {
        $params       = array();
        $this->_route_list[$num] = array(
            'format'=> preg_replace('/\:([a-zA-Z0-9-_]+)/e', '$this->_replaceParams("\1", $params);', $pattern ),
            'params'=>$params,
            'defaults'=>$default
        );
    }

    /**
     * URIを解析して、結果パラメタを返却する
     */
    public function routeURI( $uri )
    {
        foreach( $this->_route_list as $route )
        {
            $regex = $route['format'];

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

    private function _replaceParams( $name, &$params )
    {
        $params[] = $name;
        return "(.+)";
    }

}
