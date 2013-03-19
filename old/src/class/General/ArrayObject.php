<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @category   Web
 * @package    Request
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\General;

/**
 * リクエストクラス
 * PHP\ArrayObjectを良くある感じに拡張
 */
class ArrayObject extends \ArrayObject
{
    public function set( $name, $value )
    {
        if( is_array($name) )
        {
            foreach( $name as $k=>$v )
            {
                $this->set( $k, $v );
            }
        }
        $this->offsetSet( $name, $value );
    }

    public function get( $name, $default = null )
    {
        if( !$this->offsetExists($name) ) return $default;
        return $this->offsetGet($name);
    }
}
