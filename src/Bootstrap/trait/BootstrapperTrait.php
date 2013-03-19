<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 * テストファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, nora project all rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正bsdライセンス
 * @version    $id$
 */

namespace Nora\Bootstrap;

use Nora\Service;
use Nora\General\Helper;

/**
 * ブートストラッパ
 */
trait BootstrapperTrait
{
    use Service\ManagerTrait;
    use Helper\HelperTrait;

    /**
     * ヘルパメソッド
     */
    public function bootstrapper( $name = null ){
        return $this->bootstrap( $name );
    }

    /**
     * メソッドファクトリを有効にする
     * 例: _init
     */
    public function initMethodFactory( $prefix = '_init' )
    {
        foreach( get_class_methods($this) as $method )
        {
            if( 0 !== strpos($method,$prefix,0) ) continue;

            $name = substr($method,strlen($prefix));
            $this->putResource( $name, array($this,$method) );
        }
    }


    /**
     * リソースをセットする
     */
    public function putResource( $name, $resource, $setting = array() )
    {
        $this->putService('resource', $name, $resource, $setting );
    }

    /**
     * リソースを取得する
     */
    public function pullResource( $name )
    {
        return $this->pullService('resource', $name );
    }

    /**
     * リソース設定をする
     */
    public function setResourceSettings( $settings )
    {
        foreach( $settings as $name=>$value )
        {
            $this->setServiceSetting('resource', $name, $value);
        }
    }

    /**
     * ブートストラップメソッド
     */
    public function bootstrap( $name = null )
    {
        if( $name == null ) return $this;
        return $this->pullResource( $name );
    }
}

