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
 * コンポーネント
 */
trait ComponentObject
{
	private $_container;

	/**
	 * 一括でコンポーネントを設定する。
	 */
	public function configure( $config )
	{
		if(func_num_args() > 1 )
		{
			$merged_config = array();
			foreach( func_get_args( ) as $v )
			{
				$merged_config = array_merge( $merged_config, $v );
			}
			return $this->configure( $merged_config );
		}

		foreach( $config as $key=>$value )
		{
			$this->config( $key, $value );
		}
	}


	/**
	 * configXXX というメソッドがあれば
	 * そのメソッドに処理を委譲する
	 */
	public function config( $name, $value )
	{
		if( method_exists( $this, $method = 'config'.ucfirst($name) ) )
		{
			call_user_func( array( $this, $method ), $value );
		}
	}

	/**
	 * 親コンテナをセット
	 */
	public function setContainer( $container )
	{
		$this->_container = $container;
	}

	/**
	 * 親コンテナを取得
	 */
	public function getContainer( )
	{
		return $this->_container;
	}

	/**
	 * 親コンテナがセットされているか
	 */
	public function hasContainer( )
	{
		return $this->_container ? true: false;
	}

	/**
	 * 親コンテナからコンポーネントを探す
	 */
	public function findComponent( $name )
	{
		if( $this instanceof ContainerObjectIF )
		{ 
			// 自身がコンテナならばまず自分から
			if($this->hasComponent( $name ) )
			{
				return $this->getComponent( $name );
			}
		}

		if( $this->hasContainer( ) )
		{
			if( $this->getContainer( ) instanceof ComponentObjectIF )
			{
				return $this->getContainer()->findComponent( $name );
			}
			else
			{
				return $this->getContainer( )->component( $name );
			}
		}
	}
}