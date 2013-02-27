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
	use Validatable;

	protected $_id;
	protected $_value;
	protected $_renderer = 'Nora\Html\Form\Renderer\Element';

	// 要素が持つコンテクスト
	private $_label      = 'Nora\Html\Form\Element\Label';
	private $_help       = 'Nora\Html\Form\Element\Help';
	private $_validator;
	private $_is_frozen = false;

	public function __construct( $id )
	{
		$this->setId( $id );
	}

	public function getName( )
	{
		return $this->_name ? $this->_name: $this->getId();
	}

	// 各要素へのアクセッサー
	public function setLabel( $label, $attrs = array(), $props = array() )
	{
		$this->label( $label, $attrs, $props);
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
	public function label( $label = null, $attrs = array(), $props = array())
	{
		if( is_string($this->_label) )
		{
			$rc = new ReflectionClass($this->_label);
			$this->_label = $rc->newInstance( $attrs, $props );
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
	public function help( $help = null, $attrs = array(), $props = array())
	{
		if( is_string($this->_help) )
		{
			$rc = new ReflectionClass($this->_help);
			$this->_help = $rc->newInstance( $attrs, $props );
		}
		if( $help != null)
		{
			$this->_help->sethelp( $help );
		}
		return $this->_help;
	}

	/**
	 * バリューを設定する
	 */
	public function inputValues( $values = array( ) )
	{
		$name = $this->getName();
		if(isset($values[$name]))
		{
			$this->inputValue($values[$name]);
		}
	}

	/**
	 * バリューを設定する
	 */
	public function inputValue( $value = null )
	{
		if( $value != null )
		{
			$this->setValue( $value );
		}
		return $this->getValue();
	}

	/**
	 * フリーズする
	 */
	public function freeze( )
	{
		$this->_is_frozen = true;
		return $this;
	}

	public function isFrozen( )
	{
		return $this->_is_frozen;
	}

}

