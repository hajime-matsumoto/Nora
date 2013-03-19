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
namespace Nora\General\Helper;


/**
 * ヘルパブローカー機能
 */
trait BrokerOwnerTrait
{
	private $_helper_broker = false;

	/**
	 * ヘルパブローカーを設定
	 */
	public function setHelperBroker( BrokerIF $broker )
	{
		$this->_helper_broker = $broker;
		return $this;
	}

	/**
	 * ヘルパブローカーを取得
	 */
	public function getHelperBroker( )
    {
        if( $this->_helper_broker ) return $this->_helper_broker;

        $this->setHelperBroker( new Broker( ) );
        return $this->getHelperBroker( );
	}

	/**
	 * ヘルパーを取得
	 */
	public function helper( $name )
	{
		return $this->getHelperBroker( )->pullHelper($name);
	}
}

