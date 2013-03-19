<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @category   Event
 * @package    Event
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Event;


/**
 * イベント監視基本機能
 */
trait ObserverTrait
    {
        private $_event_handlers = array();

        public function receiveEvent( Event $event )
        {
            if( !isset($this->_event_handlers[$event->getName()]) ) return;
            if( !is_array($this->_event_handlers[$event->getName()]) ) return;

            foreach( $this->_event_handlers[$event->getName()] as $handler )
            {
                $args = array( $event );
                $args = array_merge( $args, $event->getArgs());
                $result = call_user_func_array( $handler, $args );
                if( $result === false ) break;
            }
        }

        public function addEventHandler( $event, $handler, $name = null )
        {
            if( $name == null )
            {
                $this->_event_handlers[$event][] = $handler;
                return;
            }

            $this->_event_handlers[$event][$name] = $handler;
        }
    }



