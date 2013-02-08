<?php
/**
 * のらライブラリ
 */
namespace Nora\DI;

use Nora;
use Exception;
/**
 * のらライブラリ
 */
namespace Nora\DI;

use Nora;
use Exception;

/**
 * DIコンテナ
 */
class Container
{
	private $_registry = array( );
	private $_factories = array();
	private $_options = array();


	/** サービスを追加 */
	public function addService( $name, $service, array $options = NULL )
	{
		if(is_object($service) && !$service instanceof \Closure)
		{
			$this->_registry[$name] = $service;
			$this->_options[$name] = $options;
			return $this;
		}

		$this->_factories[$name] = $service;
		$this->_options[$name] = $options;
		unset($this->_registry[$name]);
	}

	/** サービスを初期化か取得 */
	public function service( $name )
	{
		// Factoriesに登録されているが作成されていない。
		if(isset($this->_factories[$name]) && !isset( $this->_registry[$name] )) 
		{
			$this->_registry[$name] = $this->createService( $name );
		}
		return $this->getService( $name );
	}

	/** サービスを取得 */
	protected function getService( $name )
	{
		return $this->_registry[$name] ? $this->_registry[$name]: false;
	}

	/** サービスを初期化 */
	public function createService( $name )
	{
		$factory = $this->_factories[$name];
		if( is_object($factory) && $factory instanceof \Closure )
		{
			return call_user_func( $factory );
		}
		elseif( is_string( $factory ) && class_exists($factory)) 
		{
			// クラスを生成
			$service = new $factory( );
			$service->configure( array('DI'=>$this), $this->getServiceOptions( $name ) );
			return $service->factory( );
		}
	}

	/** サービス初期化オプションを取得 */
	public function getServiceOptions( $name )
	{
		return $this->_options[$name] ? $this->_options[$name]: array();
	}
	
}
