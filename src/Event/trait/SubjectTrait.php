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
trait SubjectTrait
{
    private $_observers = array();

    /**
     * オブザーバをセットする
     */
    public function attachObserver( ObserverIF $observer )
    {
        $this->_observers[] = $observer;
    }

    /**
     * オブザーバを削除する
     */
    public function detachObserver( ObserverIF $observer )
    {
        foreach( $this->_observers as $k=>$v )
        {
            if( $v === $observer ) unset( $this->_observers[$k] );
        }
    }

    /**
     * オブザーバにイベントを送信する
     */
    public function triggerEvent( $event, $event_args = array() )
    {
        if( !$event instanceof EventIF ) {
            return $this->triggerEvent(
                $this->createEvent( $event, $event_args ) 
            );
        }

        foreach( $this->_observers as $observer )
        {
            $observer->reciveEvent( $event );
        }
    }

    /**
     * イベントを作成する
     */
    public function createEvent( $event_name, $event_args = array( ) )
    {
        $event = new Event( $event_name, $event_args );
        $event->setSubject( $this );
        return $event;
    }
}
