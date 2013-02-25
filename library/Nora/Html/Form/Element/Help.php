<?php
/*
 * のらライブラリ
 *---------------------- 
 * 
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Html\Form\Element;

use Nora\Html;
use ReflectionClass;


/**
 * フォーム
 */
class Help extends Element
{
	protected $_help;

	public function __construct( $help, $props = array(), $attributes = array() )
	{
		$this->_help = $help;
		parent::__construct( 'help', $props, $attributes );
	}
}
