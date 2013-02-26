<?php
namespace Nora\Html\Form\Element;

use ReflectionClass;

/**
 * レンダー可能
 */
trait Renderable
{
	// 要素が持つコンテクスト
	// private $_renderer = 'Nora\Html\Form\Renderer\Element';


	// 各要素へのアクセッサー

	/**
	 * レンダラー
	 */
	public function renderer( $renderer = null )
	{
		if( $renderer != null )
		{
			$this->_renderer = $renderer;
		}

		if( is_string( $this->_renderer ) )
		{
			$rc = new ReflectionClass($this->_renderer);
			$this->_renderer = $rc->newInstance($this);
		}
		return $this->_renderer;
	}

	/**
	 * レンダー
	 */
	public function render( )
	{
		return $this->renderer( )->render( );
	}

	/**
	 * SetAttrを奪う？
	 */
	public function setAttr( $name, $value  = null)
	{
		if( is_array($name) )
		{
			foreach( $name as $k=>$v )
			{
				$this->setAttr( $k, $v );
			}
			return $this;
		}
		$this->renderer()->setAttr($name, $value);
		return $this;
	}


	// ステータス操作
	public function error( )
	{
		$this->renderer( )->error();
		return $this;
	}

}

