<?php
/**
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

namespace Nora\DI;

/**
 * コンポーネント
 */
class Component implements ComponentIF
{
	use Componentable;

	private $_container, $_coponent_name;

	/*
	public function __construct( $contaienr, $component_name )
	{
		$this->_container = $contaienr;
		$this->_conponent_name = $component_name;
	}
	 */
}
