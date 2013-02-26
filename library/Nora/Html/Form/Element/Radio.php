<?php
namespace Nora\Html\Form\Element;

/**
 * ラジオボタン
 */
class Radio extends Element
{

	protected $_id;
	protected $_name;
	protected $_value;
	protected $_dispLabel;
	protected $_renderer = 'Nora\Html\Form\Renderer\Radio';
	protected $_format = '<label class="radio"><input type="radio" id=":id" name=":name" value=":value" :attributes>:dispLabel</label>';

	public function __construct( $id, $attrs = array(), $params = array() )
	{
		parent::__construct($id);
		$this->setAttr( $attrs );
		$this->autoPropSetArray($params);
	}
}

