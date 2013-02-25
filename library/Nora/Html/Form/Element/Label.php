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
class Label extends Element
{
	protected $_name,  $_tagName = 'label', $_label, $_postfix="</:tagname>\n";

	public function __construct( $label, $attributes = array(), $props = array() )
	{
		$this->_label = $label;
		$this->autoPropSetArray($props);
		$this->setAttrs($attributes);
	}

	public function __toString( )
	{
		return $this->autoPropFormat('<label:builtAttrs>:label</label>');
	}
}
