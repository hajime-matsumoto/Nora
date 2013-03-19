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
interface BrokerOwnerIF
{
    /**
     * ヘルパブローカを追加する
     */
    public function setHelperBroker( $broker );

    /**
     * ヘルパブローカを取得する
     */
    public function getHelperBroker( );

}
