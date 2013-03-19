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

use Exception;
use Nora\Service;

/**
 * ヘルパブローカー機能
 */
trait BrokerTrait
{
    use Service\ManagerTrait;

	private $_helper_broker = false;

	/**
	 * ヘルパを設定
	 */
	public function putHelper( $name, $factory )
	{
		$this->putService( 'helper', $name, $factory );
		return $this;
	}

	/**
	 * ヘルパを取得
	 */
	public function pullHelper( $name )
	{
		if( !$this->hasService( 'helper', $name ) )
		{
			throw new NoHelperFoundException( $name );
		}

		return $this->pullService( 'helper', $name );
	}

	/**
	 * ヘルパーを取得
	 */
	public function helper( $name )
	{
		return $this->getHelperBroker( )->pullHelper($name);
	}
}

class NoHelperFoundException extends Exception
{
	public function __construct( $helper_name )
	{
		parent::__construct( sprintf("ヘルパー %s が見つかりません", $helper_name ));
	}
}
