<?php
namespace Nora\Html\Form\Element;

/**
 * ラジオボタン(複数)
 */
class Radios extends Group
{

	protected $_id;
	protected $_name;
	protected $_value;
	protected $_renderer = 'Nora\Html\Form\Renderer\Radios';

	public function __construct( $id, $datas, $attrs = array(), $params = array() )
	{
		parent::__construct( $id, $attrs, $params );
		$isFirst = true;
		foreach( $datas as $k=>$v )
		{
			if( $isFirst )
			{
				$isFirst = false;
				$this->addRadio( $id.":".$k, array('checked'), array('name'=>$id,'value'=>$k,'dispLabel'=>$v));
			}else{
				$this->addRadio( $id.":".$k, array(), array('name'=>$id,'value'=>$k,'dispLabel'=>$v));
			}
		}
	}
}
