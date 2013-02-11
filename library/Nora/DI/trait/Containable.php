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
trait Containable
{
	private $_registry = array();
	private $_options = array();
	private $_factories = array();

	/** 
	 * コンポーネントを追加する
	 */
	public function addComponent( $name, $component, $options = array() )
	{
		$name = strtolower($name);

		$this->_options[$name] = $options;

		if( $component instanceof \Closure)
		{
			$this->_factories[$name] = $component;
			return $this;
		}
		elseif(is_object( $component ) && !$component instanceof Callback ) 
		{
			$this->_registry[$name] = $component;
			return $this;
		}

		$this->_factories[$name] = $component;
		return $this;
	}

	public function component( $name )
	{
		$name = strtolower($name);

		if( !$this->hasComponent( $name ) )
		{
			throw new Exception( "$name is not found ") ;
		}
		if( !$this->isComponentCreated($name) )
		{
			$this->initComponent($name);
		}
		return $this->getComponent( $name );
	}

	public function hasComponent( $name )
	{
		$name = strtolower($name);
		return isset($this->_registry[$name]) || isset($this->_factories[$name]);
	}

	public function isComponentCreated( $name )
	{
		$name = strtolower($name);
		return isset($this->_registry[$name]);
	}

	public function getComponent( $name )
	{
		$name = strtolower($name);
		return $this->_registry[$name];
	}

	public function initComponent( $name )
	{
		$name = strtolower($name);
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

			if( $rc->isSubclassOf('Nora\DI\ComponentIF')  )
			{
				$factory = $rc->newInstance( );
				$factory->configure( $this->getComponentOptions($name ) );
				$component = $factory->factory();
			}else{
				$component = $rc->newInstance( $this, $name );
			}
		}
		$this->_registry[$name] = $component;
		return $component;
	}

	public function getComponentOptions( $name )
	{
		$name = strtolower($name);
		return isset($this->_options[$name]) ? $this->_options[$name] : array();
	}

	public function configComponent( $name, $config )
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
