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
namespace Nora\General\Bootstrap;

/**
 * ブートストラッパTrait
 */
trait BootstrapperTrait
{
    private $_is_bootstrapper_initialized = false;
    private $_bootstrap_resource = array();
    private $_bootstrap_registry = array();

    private function bootstrapperInitialize( )
    {
        $_is_bootstrapper_initialized = true;
        foreach( get_object_methods($this) as $method )
        {
            if( 0 === strpos( $method, '_init', 0 ) )
            {
                $this->addBootstrapResource( substr($method,4), array($this,$method) );
            }
        }
    }

    /**
     * ブートストラップリソースを追加
     */
    public function addBootstrapResource( $name, $factory )
    {
        $this->_bootstrap_resource[$name] = $factory;
    }

    /**
     * ブートストラップリソースが存在するか
     */
    public function hasBootstrapResource( $name )
    {
        if( isset($this->_bootstrap_register[$name]) ) return true;
        if( isset($this->_bootstrap_resource[$name]) ) return true;
        return false;
    }

    /**
     * 初期化する
     */
    public function bootstrap( $name )
    {
        if( !$this->_bootstrap_resource[$name] ) return;
        if( $this->_bootstrap_registry[$name] ) return $this->_bootstrap_registry[$name];

        $factory = $this->_bootstrap_resource[$name];
        if( is_callable($factory) )
        {
            return $this->_bootstrap_registry[$name] = call_user_func($factory);
        }
    }
}
