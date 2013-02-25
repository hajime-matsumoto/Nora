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
class Controls extends Group
{
	public function __construct( $attributes = array(), $props = array() )
	{
		$this->autoPropSetArray($props);
		$this->setAttrs($attributes);
	}

}
