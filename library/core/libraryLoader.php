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
	
	/**
	 * 未定義クラスが呼ばれた時に呼ばれる
	 * オートロード関数
	 *
	 * @param string クラス名
	 */
	public function audoLoad( $name )
	{
		// クラスファイルの検索開始
		foreach( $this->_search_path as $path )
		{
			// 検索候補かチェック
			if( $this->_isPossibleSearchPath( $path, $name ) )
			{
				// クラス名からパスを推定
				if( $fil = $this->_guessFilePath( $path, $name ) )
				{
					require_once $file;
				}
				// Debug
				var_Dump($file);
			}
		}
	}

	/**
	 * クラスの完全修飾名からパスを推測する
	 *
	 * @param array path['prefix'],['dirname']
	 * @param string クラス名
	 */
	private function _guessFilePath( $path, $name )
	{
		// プレフィックスを登録されているパスに変換
		$path = preg_replace('/^'.preg_quote($path['prefix']).'/',$path['dirname'].'/', $name);

		// クラスの完全修飾名をパスに変換する
		//  \\ と _ を /に変換
		$path = str_replace(array('\\','_'), '/', $path);

		// 大文字、小文字の調整
		$dirname = strtolower(dirname($path));
		$basename = lcfirst(basename($path));

		foreach( array('','/class','/trait','/abstract','/interface') as $type )
		{
			if( file_exists( $file = sprintf('%s%s/%s.php',$dirname, $type, $basename ) ) )
			{
				return $file;
			}
		}
	}

	// クラスが存在する可能性があれば True
	private function _isPossibleSearchPath( $path, $name )
	{
		$prefix = $path['prefix'];
		$dirname = $path['dirname'];

		if( 0 === substr_compare($name,$prefix,0,strlen($prefix)) )
		{
			return true;
		}
		return false;
	}
}
