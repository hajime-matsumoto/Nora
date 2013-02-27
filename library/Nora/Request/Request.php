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

use Nora\Container\Container;

/**
 * リクエスト
 */
class Request
{
	static public function factory( $type )
	{
		$rc = new \ReflectionClass(__NAMESPACE__.'\\'.ucfirst($type));
		return $rc->newInstance();
	}
}
