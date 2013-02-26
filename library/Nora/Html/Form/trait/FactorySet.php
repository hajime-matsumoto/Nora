<?php
namespace Nora\Html\Form;
use ReflectionClass;

/**
 * Formコンポーネントを生成する
 */
trait FactorySet
{

	/**
	 * Textエレメントを作成する
	 */
	public function createText( )
	{
		return $this->createElementArray( 'Text', func_get_Args() );
	}

	/**
	 * 
	 */
	public function createGroup( )
	{
		return $this->createElementArray( 'Group', func_get_Args() );
	}

	/**
	 * フィールドセットを作成し、追加する
	 */
	public function fieldset( $name )
	{
		$elem = $this->createElementArray( 'Fieldset', func_get_args() );
		$this->addElement( $elem );
		return $elem;
	}

	/**
	 * グループを作成し、追加する
	 */
	public function group( $name )
	{
		$elem = $this->createElementArray( 'Group', func_get_args() );
		$this->addElement( $elem );
		return $elem;
	}

	/**
	 * テキストフィールドを作成し、追加する
	 */
	public function addText( $name )
	{
		$elem = $this->createElementArray( 'Text', func_get_args() );
		$this->addElement( $elem );
		return $this;
	}

	/**
	 * ボタンを作成し、追加する
	 */
	public function addButton( $name )
	{
		$elem = $this->createElementArray( 'Button', func_get_args() );
		$this->addElement( $elem );
		return $this;
	}

	/**
	 * ラジオボタンを作成し、追加する
	 */
	public function addRadio( $name )
	{
		$elem = $this->createElementArray( 'Radio', func_get_args() );
		$this->addElement( $elem );
		return $this;
	}
	/**
	 * ラジオボタン(複数)を作成し、追加する
	 */
	public function addRadios( $name, $datas )
	{
		$elem = $this->createElementArray( 'Radios', func_get_args() );
		$this->addElement( $elem );
		return $this;
	}

		
		


	/**
	 * Typeをクラス名にする。
	 * 第二引数はクラスのコンストラクタへ渡す
	 */
	public function createElementArray( $type, $args )
	{
		array_unshift($args, $type);
		return call_user_func_array( array($this,'createElement'), $args );
	}

	/**
	 * Typeをクラス名にする。
	 * 第二引数以降はクラスのコンストラクタへ渡す
	 */
	public function createElement( )
	{
		$args = func_get_args();
		$type = array_shift($args);
		$rc = new ReflectionClass(__NAMESPACE__.'\Element\\'.$type);
		return $rc->newInstanceArgs( $args );
	}

}
