<?php
/**
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

namespace Nora\DI;

/**
 * コンポーネントコンテナ
 */
trait ContainerObject
{
	private $_registry = array();
	private $_options = array();
	private $_factories = array();

	/**
	 * インスタンスをリセット
	 */
	public function clearInstance( )
	{
		$this->_registry = array();
	}

	/**
	 * ユーティリティ
	 * ================================= */

	/**
	 * 名前を小文字に変える
	 */
	private function _nameNomarize( $name )
	{
		return strtolower( $name );
	}

	/**
	 * コンポーネントインスタンスが存在するか。
	 */
	private function _isComponentCreated( $name )
	{
		$name = $this->_nameNomarize($name);
		return isset($this->_registry[$name]);
	}

	/** 
	 * コンポーネントを追加する
	 */
	public function addComponent( $name, $component, $options = array() )
	{
		$name = $this->_nameNomarize( $name );

		if( $component instanceof \Closure)
		{
			$this->_factories[$name] = $component;
			$this->_options[$name] = $options;
			return $this;
		}
		elseif(is_object( $component ) && !$component instanceof Callback ) 
		{
			$this->_registry[$name] = $component;
			return $this;
		}else{
			$this->_options[$name] = $options;
			$this->_factories[$name] = $component;
			return $this;
		}
	}

	/**
	 * コンポーネントを初期化する
	 */
	public function component( $name )
	{
		$name = $this->_nameNomarize($name);

		if( !$this->hasComponent( $name ) )
		{
			throw new Exception( "$name is not found ") ;
		}
		if( !$this->_isComponentCreated($name) )
		{
			$this->_initComponent($name);
		}
		return $this->getComponent( $name );
	}

	/**
	 * コンポーネントが存在するか。
	 */
	public function hasComponent( $name )
	{
		$name = $this->_nameNomarize($name);
		return isset($this->_registry[$name]) || isset($this->_factories[$name]);
	}


	/**
	 * コンポーネントインスタンスを取得
	 */
	public function getComponent( $name )
	{
		$name = $this->_nameNomarize($name);
		return $this->_registry[$name];
	}

	/**
	 * コンポーネントインスタンスを作成
	 */
	private function _initComponent( $name )
	{
		$name = $this->_nameNomarize($name);

		$factory = $this->_factories[$name];

		if( $factory instanceof \Closure )
		{
			$component = call_user_func( $factory, $this, $name );
		}
		elseif( $factory instanceof Callback )
		{
			$component = $factory->__invoke();
		}else{
			if( is_string($factory) && !class_exists( $factory ) )
			{
				throw new Exception( 'Invalid Factory' .' '.$factory);
			}

			$rc = new \ReflectionClass( $factory );

			if( $rc->isSubclassOf('Nora\DI\ComponentObjectIF')  )
			{
				$factory = $rc->newInstance( );
				$factory->setContainer( $this );
				$factory->configure( $this->getComponentOptions($name ) );
				$factory->init( );
				$component = $factory->factory();
			}else{
				$component = $rc->newInstance( $this, $name );
			}
		}
		$this->_registry[$name] = $component;
		return $component;
	}

	/**
	 * コンポーネントオプションを作成
	 */
	public function getComponentOptions( $name )
	{
		$name = strtolower($name);
		return isset($this->_options[$name]) ? $this->_options[$name] : array();
	}

	/**
	 * コンポーネントオプションを設定
	 */
	public function setComponentOptions( $name, $config )
	{
		$name = strtolower($name);
		$this->_options[$name] = $config;
		return $this;
	}

	public function __get( $name )
	{
		return $this->component( $name );
	}
}

class Exception extends \Exception{}
