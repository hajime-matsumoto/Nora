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
 * イベントマネージャー基本機能
 */
trait ManagerTrait
{
    use ObserverTrait;

    private $_observers = array();

    public function __construct( )
    {
        $this->_observers = array($this);
    }

    public function addEventObserver( $observer )
    {
        $this->_observers[] = $observer;
    }

    public function trigger( )
    {
        $args  = func_get_args( );
        $name  = array_shift( $args );
        $event = new Event( $name, $args, $this );

        foreach( $this->_observers as $observer )
        {
            $observer->receiveEvent( $event );
        }
    }
}



