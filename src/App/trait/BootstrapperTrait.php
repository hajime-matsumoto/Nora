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
namespace Nora\App;

use Nora\General;
use Nora\Service;

/**
 * アプリケーションブートストラッパ
 */
trait BootstrapperTrait
{
    use Service\ManagerOwnerTrait;
    use General\Helper\HelperTrait;

    /**
     * ヘルパとして実行された時
     */
    public function bootstrapper( $name = null)
    {
        if( $name == null ) return $this;

        return $this->pullResource( $name );
    }

    /**
     * Bootstrapの初期化
     */
    public function initialize( Service\ManagerIF $manager)
    {
        foreach( get_class_methods($this) as $func )
        {
            if( 0 === strpos($func,'_init') )
            {
                $name = substr($func,5);
                $this->putResource($name, array($this,$func) );
            }
        }
    }

    /**
     * リソースの追加
     */
    public function putResource( $name, $factory )
    {
        return $this->getServiceManager( )->putService('resource', $name, $factory );
    }

    /**
     * リソースの取得
     */
    public function pullResource( $name )
    {
        return $this->getServiceManager( )->pullService('resource', $name);
    }

    /**
     * 初期化関数
     */
    public function bootstrap( $name = null )
    {
        return $this->pullResource( $name );
    }
}
