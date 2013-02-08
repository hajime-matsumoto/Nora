<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Core;

/**
 * コンフィグ機能
 *
 * - configure( 配列 )
 * - config{Key}(値)
 *
 * @author Hajime MATUMOTO <mail@hazime.org>
 */
trait AutoConfig
{
	private $_config = array();

	/**
	 * configされた配列を一括で取得　
	 */
	public function getConfigs( )
	{
		return $this->_config;
	}

	/**
	 * configXXX というメソッドがあればそのメソッドを取得する
	 */
	public function configure( $config )
	{
		$this->_config = $config;

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
			//
			// configXXX というメソッドがあればそのメソッドを取得する
			//
			if( method_exists( $this, $method = 'config'.ucfirst($key) ) )
			{
				call_user_func( array( $this, $method ), $value );
			}
		}
	}
}
