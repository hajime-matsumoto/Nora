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
trait Componentable
{
	/** 
	 * 実態を取得する
	 */
	public function factory( )
	{
		return $this;
	}

	/**
	 * configXXX というメソッドがあれば
	 * そのメソッドに処理を委譲する
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
			if( method_exists( $this, $method = 'config'.ucfirst($key) ) )
			{
				call_user_func( array( $this, $method ), $value );
			}
		}
	}
}
