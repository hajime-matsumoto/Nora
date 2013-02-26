<?php
namespace Nora\Html\Form\Element;

/**
 * テキストフィールド
 */
class Textarea extends Element
{

	protected $_id;
	protected $_name;
	protected $_value;
	protected $_format = '<textarea type="text" id=":id" name=":name" :attributes>:value</textarea>';

	public function __construct( $id, $attrs = array(), $props = array() )
	{
		parent::__construct( $id );
		$this->setAttr( $attrs );
		$this->autoPropSetArray( $props );
	}

}

