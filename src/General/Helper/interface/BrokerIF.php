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

use Nora\Service;

/**
 * ヘルパブローカーインターフェイス
 */
interface BrokerIF extends Service\ManagerIF
{
	/**
	 * ヘルパを設定
	 */
	public function putHelper( $name, $factory );

	/**
	 * ヘルパを取得
	 */
	public function pullHelper( $name );

	/**
	 * ヘルパーを取得
	 */
	public function helper( $name );
}

