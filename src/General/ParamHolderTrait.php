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
namespace Nora\General;


/**
 * パラメータホルダー
 */
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

    public function delParam( $name )
    {
        unset($this->_params[$name]);
        return $this;
    }

    public function getParamsF( $format )
    {
        if( func_num_args() < 2 ) return $format;

        $params = array();
        for( $i=1; $i<func_num_args(); $i++ )
        {
            $params[] = $this->getParam(func_get_arg($i));
        }

        return vsprintf( $format, $params );
    }
}
