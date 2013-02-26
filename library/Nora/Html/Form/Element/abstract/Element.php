<?php
namespace Nora\Html\Form\Element;

use Nora\Collection;
use ReflectionClass;

/**
 * テキストフィールド
 */
abstract class Element
{
	use Collection\AutoPropSet;
	use Renderable;

	protected $_id;
	protected $_renderer = 'Nora\Html\Form\Renderer\Element';

	// 要素が持つコンテクスト
	private $_label      = 'Nora\Html\Form\Element\Label';
	private $_help       = 'Nora\Html\Form\Element\Help';
	private $_validator;

	public function __construct( $id )
	{
		$this->setId( $id );
	}

	public function getName( )
	{
		return $this->_name ? $this->_name: $this->getId();
	}

	// 各要素へのアクセッサー
	public function setLabel( $label )
	{
		$this->label( $label );
		return $this;
	}

	public function setHelp( $help )
	{
		$this->help($help);
		return $this;
	}

	/**
	 * ラベル
	 */
	public function label( $label = null)
	{
		if( is_string($this->_label) )
		{
			$rc = new ReflectionClass($this->_label);
			$this->_label = $rc->newInstance();
		}
		if( $label != null)
		{
			$this->_label->setLabel( $label );
		}
		return $this->_label;
	}

	/**
	 * ヘルプ
	 */
	public function help( $help = null)
	{
		if( is_string($this->_help) )
		{
			$rc = new ReflectionClass($this->_help);
			$this->_help = $rc->newInstance();
		}
		if( $help != null)
		{
			$this->_help->sethelp( $help );
		}
		return $this->_help;
	}


}

