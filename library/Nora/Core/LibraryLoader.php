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
	const NAME_SPACE_SEPARATOR = '\\';
	const CLASS_NAME_SEPARATOR = '_';

	private $_search_path = array();

	/**
	 * クラスの検索パスを追加する。
	 *
	 * @param string ディレクトリパス
	 * @param string クラスプレフィックス
	 */
	public function addSearchPath( $dirname, $prefix = null )
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
	public function autoLoad( $name )
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
		$prefix = $path['prefix'];
		$dirname = $path['dirname'];

		// プレフィックスを登録されているパスに変換

		// 変換用の正規表現を作成
		$regex = sprintf('/^%s/',preg_quote( $prefix ) );

		// プレフィックスをディレクトリ名に変更
		$path = preg_replace( $regex, $dirname, $name);

		// クラス名からパスを生成
		$path = str_replace(NAME_SPACE_SEPARATOR,'/',$name);
		$path = str_replace(CLASS_NAME_SEPARATOR,'/',$name);

		foreach( array('','/class','/trait','/abstract','/interface') as $type )
		{
			if( file_exists( $file = sprintf('%s%s/%s.php',$dirname, $type, $basename ) ) )
			{
				return $file;
			}
		}
	}

	/**
	 * 検索パスを絞り込む
	 *
	 * クラスが存在する可能性があれば真
	 * プレフィックスが存在しなければ常に真
	 *
	 * @param array path 
	 * @param string name
	 */
	private function _isPossibleSearchPath( $path, $name )
	{
		$prefix = $path['prefix'];
		if( empty($prefix) )
		{
			return true;
		}

		if( 0 === substr_compare($name,$prefix,0,strlen($prefix)) )
		{
			return true;
		}
		return false;
	}
}
