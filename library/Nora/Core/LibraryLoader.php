<?php
/**
 * のらライブラリ
 *---------------------- 
 *
 *---------------------- 
 * @author Hajime MATUMOTO <mail@hazime.org>
 *---------------------- 
 */

namespace Nora\Core;

/**
 * ライブラリローダー
 * 
 * ライブラリのクラスをオートロードするクラス
 *
 */
class LibraryLoader
{
	const NAME_SPACE_SEPARATOR = '\\'; # ネームスペースの区切り文字
	const CLASS_NAME_SEPARATOR = '_';  # クラス名の区切り文字

	private $_search_path = array();

	/**
	 * レジスター, SPL関数でAutoloadに設定する
	 */
	public function register( )
	{
		spl_autoload_register( array($this, 'autoLoad') );
	}

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
			'dirname'=>trim($dirname),
			'prefix'=>trim($prefix)
		);
	}
	
	/**
	 * 未定義クラスが呼ばれた時に呼ばれる
	 * オートロード関数
	 *
	 * @param string クラス名
	 * @param bool デバッグフラグ 初期値は偽
	 */
	public function autoLoad( $name, $isDebug = false )
	{
		// クラスファイルの検索開始
		foreach( $this->_search_path as $path )
		{
			// 検索候補かチェック
			if( $this->_isPossibleSearchPath( $path, $name ) )
			{
				// クラス名からパスを推定
				if( $found_file = $this->_guessFilePath( $path, $name ) )
				{
					// デバッグ中ならば
					// ファイルをロードしないでファイル名を返却
					if( $isDebug == false )
					{
						require_once $found_file;
						return true;
					}
					return $found_file;
				}
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
		$path = $this->_applyPrefixPath( $path, $name );

		// クラス名からパスを生成
		$path = str_replace(self::NAME_SPACE_SEPARATOR,'/',$path);
		$path = str_replace(self::CLASS_NAME_SEPARATOR,'/',$path);

		foreach( array('','/class','/trait','/abstract','/interface') as $type )
		{
			if( file_exists( $file = sprintf('%s%s/%s.php',dirname($path), $type, basename($path) ) ) )
			{
				return $file;
			}
		}
	}

	/** 
	 * プレフィックスを登録されているパスに変換
	 *
	 * @param array path['prefix'],['dirname']
	 * @param string クラス名
	 */
	private function _applyPrefixPath( $path, $name )
	{
		$prefix = $path['prefix'];
		$dirname = $path['dirname'];

		if( empty($prefix) )
		{
			return sprintf('%s/%s',$dirname,$name);
		}
		// 変換用の正規表現を作成
		$regex = sprintf('/^%s/',preg_quote( $prefix ) );
		// プレフィックスをディレクトリ名に変更
		return preg_replace( $regex, $dirname, $name);
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
