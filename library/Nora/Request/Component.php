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
use Nora\DI;

/**
 * リクエスト
 */
class Component implements DI\ComponentObjectIF
{
	use DI\ComponentObject;

	protected $_type = 'web';

	protected function configType($type)
	{
		$this->_type = $type;
	}

	public function init( )
	{

	}

	public function factory( )
	{
		return Request::factory($this->_type);

	}
}
