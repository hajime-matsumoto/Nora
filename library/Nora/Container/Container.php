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

/**
 * コンテナクラス
 *
 * キーバリューでアクセス出来るデータコンテナ
 *
 */
class Container implements \IteratorAggregate
{
	private $_my_data = array();

	/**
	 * データを取得する。
	 * もし、データがセットされていなければ
	 * 第ニ引数をリターンする
	 *
	 * @param キー
	 * @param 初期値
	 * @return
	 */
	public function getData( $key, $default = null )
	{
		if( $this->hasData( $key ) )
		{
			return $this->_getData( $key );
		}
		return $default;
	}

	/**
	 * データを取得する実態
	 *
	 * @param キー
	 * @return
	 */
	protected function _getData( $key )
	{
		return $this->_my_data[$key];
	}

	/**
	 * データが存在するか？
	 *
	 * @param キー
	 * @param 存在する場合の戻り値
	 * @param 存在しない場合の戻り値
	 * @return
	 */
	public function hasData( $key, $yes = true, $no = false )
	{
		return isset($this->_my_data[$key]) ? $yes : $no;
	}

	/**
	 * データを保存する
	 *
	 * @param キー
	 * @param 値
	 */
	public function setData( $key, $data  = false)
	{
		// もしも、引数が配列１個だけだったら
		// 配列を取り込む
		if( $data == false && is_array($key) )
		{
			foreach( $key as $k=>$v )
			{
				$this->setData( $k, $v );
			}
			return $this;
		}

		$this->_my_data[$key] = $data;
		return $this;
	}

	/**
	 * オーバーロード
	 */
	public function __set( $key, $value )
	{
		return $this->setData( $key, $value );
	}
	public function __get( $key )
	{
		return $this->getData( $key, null );
	}

	public function getIterator( )
	{
		return new \ArrayIterator($this->_my_data);
	}
}




