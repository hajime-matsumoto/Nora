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
 * イベントマネージャーオーナー基本機能
 */
trait ManagerOwnerTrait
{
	private $_event_manager = 'Nora\Event\Manager';

	public function setEventManager( $class )
	{
		$this->_event_manager = $_event_manager;
	}

	public function getEventManager( )
	{
		if(is_object( $this->_event_manager ) ) return $this->_event_manager;
		return $this->_event_manager = nora_class_new_instance( $this->_event_manager );
	}
}



