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
namespace Nora\Event;

/**
 * イベント対象
 */
interface SubjectIF
{
    /**
     * オブザーバをセットする
     */
    public function attachObserver( ObserverIF $observer );

    /**
     * オブザーバを削除する
     */
    public function detachObserver( ObserverIF $observer );

    /**
     * オブザーバにイベントを送信する
     */
    public function triggerEvent( $event_name, $event_args = array() );

    /**
     * イベントを作成する
     */
    public function createEvent( $event_name, $event_args = array( ) );

}
