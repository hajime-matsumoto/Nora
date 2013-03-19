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
namespace Nora\General\Helper;

/**
 * ヘルパーブローカオーナー
 */
trait BrokerOwnerTrait
{
    private $_helper_broker = 'Nora\General\Helper\Broker';

    /**
     * ヘルパブローカを追加する
     */
    public function setHelperBroker( $broker )
    {
        if( is_object( $broker ) )
        {
            $broker->setOwner( $this );
        }
        $this->_helper_broker = $broker;
    }

    /**
     * ヘルパブローカを取得する
     */
    public function getHelperBroker( )
    {
        if(is_object($this->_helper_broker)) return $this->_helper_broker;

        nora_load_util('class');
        $this->setHelperBroker(nora_class_new_instance( $this->_helper_broker ));
        return $this->_helper_broker;
    }

    /**
     * オーバーロード
     */
    public function __get( $name )
    {
        return $this->getHelperBroker( )->pullHelper($name);
    }

    public function __call( $name, $args )
    {
        return $this->getHelperBroker( )->invokeHelper( $name, $args );
    }
}
