<?php
namespace Nora\Html\Form\Element;

use Nora\Collection;

/**
 * ラベル
 */
class Label
{
	use Collection\AutoPropSet;
	use Renderable;

	protected $_label;
	protected $_for = '';
	protected $_renderType = 'label';
	protected $_format = '<label for=":for" :attributes>:label</label>';

	private $_renderer = 'Nora\Html\Form\Renderer\Label';

	public function __construct( $attrs = array(), $props = array() )
	{
		$this->setAttr( $attrs );
		$this->autoPropSetArray($props);
	}

	public function isEnabled( )
	{
		return $this->_label ? true: false;
	}
}

