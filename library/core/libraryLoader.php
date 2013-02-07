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

class LibraryLoader
{
	private $_search_path = array();

	/**
	 * クラスの検索パスを追加する。
	 *
	 * @param string ディレクトリパス
	 * @param string クラスプレフィックス
	 */
	public function addSearchPath( $dirname, $prefix )
	{
		// 配列添字キーを生成して、値をユニークにする。
		$array_key = $dirname."|".$prefix;

		$this->_search_path[ $array_key ] = array(
			'dirname'=>$dirname,
			'prefix'=>$prefix
		);
	}
}
