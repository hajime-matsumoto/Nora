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

/**
 * ブートストラップオーナー機能
 */
trait BootstrapperOwnerTrait
{
    private $_bootstrapper = false;

    /**
     * ブートストラッパをセットする
     */
    public function setBootstrapper( BootstrapperIF $bootstrapper )
    {
        $this->_bootstrapper = $bootstrapper;
    }

    /**
     * ブートストラッパを取得する
     */
    public function getBootstrapper( )
    {
        if( !$this->hasBootstrapper() ) {
            throw new BootstrapperNotSetYet();
        }
        return $this->_bootstrapper;
    }

    /**
     * ブートストラッパがあるか
     */
    public function hasBootstrapper( )
    {
        return $this->_bootstrapper ? true: false;
    }

    /**
     * ブートストラップリソースを取得
     */
    public function bootstrap( $name = null )
    {
        return $this->getBootstrapper( )->bootstrap( $name );
    }
}
