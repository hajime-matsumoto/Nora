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
namespace Nora\Service;


/**
 * サービスマネージャーオーナー基本機能
 */
trait ManagerOwnerTrait
{
    private $_service_manager = false;

    /**
     * 親マネージャーをセットする
     */
    public function setServiceManager( ManagerIF $manager )
    {
        $this->_service_manager = $manager;
    }

    /**
     * 親マネージャを取得する
     */
    public function getServiceManager( )
    {
        if( !$this->hasServiceManager( ) ) return false;
        return $this->_service_manager;
    }

    /**
     * 親マネージャがあるか？
     */
    public function hasServiceManager( )
    {
        return $this->_service_manager ? true: false;
    }
}
