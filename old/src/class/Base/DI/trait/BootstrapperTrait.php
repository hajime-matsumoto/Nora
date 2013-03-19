<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @category   Base
 * @package    DI
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Base\DI;

/**
 * ブートストラッパ基本機能
 */
trait BootstrapperTrait
{
    use ContainerTrait;

    public function bootstrapperInitialize( )
    {
        $_is_bootstrapper_initialized = true;
        foreach( get_class_methods($this) as $method )
        {
            if( 0 === strpos( $method, '_init', 0 ) )
            {
                $this->addComponent( strtolower(substr($method,5)), array($this,$method) );
            }
        }

        $this->initialize( );
    }

    /**
     * コンポーネントの設定値を変えてファクトリを登録し直す
     */
    public function resourceInitialize( $resources_setting )
    {
        foreach( $resources_setting as $k=>$v )
        {
            if( $factory = $this->pullFactory($k) )
            {
                $this->removeComponent($k);
                $this->addComponent($k, $factory, $v );
            }
        }
    }

    public function initialize( )
    {

    }
}
