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
 * イベントオブザーバー機能
 */
trait ObserverTrait
{
    private $_handlers = array();

    /**
     * ハンドラを登録する
     */
    public function addHandler( $event_name, $handler )
    {
        $this->_handlers[$event_name][] = $handler;
    }

    /**
     * イベントを感知する
     */
    public function reciveEvent( EventIF $event )
    {
        $event_name = $event->getName();
        if( !isset($this->_handlers[$event_name]) ) return;

        foreach( $this->_handlers[$event_name] as $handler )
        {
            call_user_func( $handler, $event );
        }
    }

}
