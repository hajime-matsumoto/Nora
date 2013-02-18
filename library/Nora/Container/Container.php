<?php
/*
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */
namespace Nora\Container;
use ArrayObject;

/**
 * コンテナクラス
 *
 * キーバリューでアクセス出来るデータコンテナ
 *
 */
class Container extends ArrayObject
{
	public function __construct( $array = array() )
	{
		parent::__construct( $array );
	}

	/**
	 * データを取得する。
	 * もし、データがセットされていなければ
	 * 第ニ引数をリターンする
	 *
	 * @param キー
	 * @param 初期値
	 * @return
	 */
	public function offsetGet( $key, $default = null )
	{
		if( $this->offsetExists( $key ) )
		{
			return parent::offsetGet( $key );
		}
		return $default;
	}

	/**
	 * データを保存する
	 *
	 * @param キー
	 * @param 値
	 */
	public function offsetSet( $key, $data  = false)
	{
		parent::offsetSet( $key, $data );
	}


	/**
	 * オーバーロード
	 */
	public function __get( $name )
	{
		return $this->offsetGet( $name );
	}

	public function __set( $name, $value )
	{
		return $this->offsetSet( $name, $value );
	}

	/**
	 * 特殊操作系
	 */
	public function append( $value )
	{
		$this->offsetSet( null, $value );
	}

	public function prepend( $value )
	{
		array_unshift( $this, $value );
	}

	public function hasData( $name, $yes = true, $no = false )
	{
		return $this->offsetExists($name) ? $yes: $no;
	}
}




