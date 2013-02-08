<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Container;

trait WithContainer
{
	private $_my_container;

	public function __construct( )
	{
		return $this->_my_container = new Container( );
	}

	public function getContainer( )
	{
		return $this->_my_container;
	}
}
