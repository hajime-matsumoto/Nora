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
 * イベントクラス
 */
class Event
{
	private $_name, $_args = array(), $_manager;

	public function __construct( $name, $args, $manager )
	{
		$this->_name = $name;
		$this->_args = $args;
		$this->_manager = $manager;
	}

	public function getName( )
	{
		return $this->_name;
	}

	public function getArgs( )
	{
		return $this->_args;
	}

	public function getManager( )
	{
		return $this->_manager;
	}
}



