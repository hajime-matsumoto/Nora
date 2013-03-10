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
class Event extends \ArrayObject implements EventIF
{
    use EventTrait;

    public function __construct( $event_name, $datas = array() )
    {
        $this->_event_name = $event_name;
        parent::__construct( $datas );
    }
}
