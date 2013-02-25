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
class Fieldset extends Group
{
	protected $legend;

	public function __construct( $name, $legend )
	{
		$this->_legend = $legend;
	}
}
