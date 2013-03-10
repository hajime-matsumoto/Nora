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
 * イベント実装
 */
trait EventTrait
{
    private $_event_name = false;
    private $_event_subject = false;

    /**
     * イベント名を設定する
     */
    public function setName( $event_name )
    {
        $this->_event_name = $event_name;
    }

    /**
     * イベント名を取得する
     */
    public function getName( )
    {
        return $this->_event_name;
    }

    /**
     * イベントサブジェクトを設定する
     */
    public function setSubject( SubjectIF $subject )
    {
        $this->_event_subject = $subject;
    }


    /**
     * イベントサブジェクトを取得する
     */
    public function getSubject( )
    {
        return $this->_event_subject;
    }
}
