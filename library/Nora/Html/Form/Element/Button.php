<?php
namespace Nora\Html\Form\Element;

/**
 * ボタン
 */
class Button extends Element
{

	protected $_id;
	protected $_name;
	protected $_value;
	protected $_type = 'button';
	protected $_format = '<button type=":type" id=":id" name=":name" :attributes>:value</button>';
	protected $_renderer = 'Nora\Html\Form\Renderer\Button';

	public function __construct( $id,  $attrs = array(), $props = array() )
	{
		parent::__construct( $id );
		$this->setAttr( $attrs );
		$this->autoPropSetArray( $props );
	}

}

