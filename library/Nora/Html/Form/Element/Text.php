<?php
namespace Nora\Html\Form\Element;

/**
 * テキストフィールド
 */
class Text extends Element
{

	protected $_id;
	protected $_name;
	protected $_value;
	protected $_format = '<input type="text" id=":id" name=":name" value=":value" :attributes>';

	public function __construct( $id, $attrs = array() )
	{
		parent::__construct( $id );
		$this->setAttr( $attrs );
	}

}

