<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @category   General
 * @package    ParamHolder
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\General;

trait ParamHolderTrait
{
    private $_params = array( );

    public function hasParam( $name )
    {
        return isset($this->_params[$name]) ? true: false;
    }

    public function getParams( )
    {
        return $this->_params;
    }

    public function getParam( $name, $default = false )
    {
        if( !$this->hasParam($name) ) return $default;
        return $this->_params[$name];
    }

    public function setParams( $array )
    {
        foreach( $array as $k=>$v )
        {
            $this->setParam( $k, $v );
        }
        return $this;
    }

    public function setParam( $name, $value )
    {
        $this->_params[$name] = $value;
        return $this;
    }

}
