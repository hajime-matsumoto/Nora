<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Request;


/**
 * リクエストイテレータ
 */
class RequestIterator extends \ArrayIterator
{
	private $_callback;

	public function __construct( $array, $callback )
	{
		parent::__construct( $array );
		$this->_callback = $callback;
	}

	public function current( )
	{
		return call_user_func($this->_callback, parent::current() );
	}
}
