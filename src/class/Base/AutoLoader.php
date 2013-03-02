<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト:クラスファイル
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\Base;

/**
 * オートロードクラス
 */
class AutoLoader
{
    /**
     * シングルトンインスタンスを保持
     */
    static private $_instance;

    /**
     * オートロード対象のネームスペースたち
     */
    private $_namespaces = array();

    /**
     * シングルトンで使用する場合
     */
    static public function getInstance( )
    {
        if( static::$_instance ) return static::$_instance;

        static::$_instance = new AutoLoader( );
        return static::$_instance;
    }

    /**
     * オートロード対象になるネームスペースを設定
     * 第二引数は検索対象となるディレクトリ
     */
    public function addNamespace( $namespace, $dirctory )
    {
        $this->_namespaces[$namespace][$dirctory] = $dirctory;
    }

    /**
     * PHPのオートロードに登録
     */
    public function register( )
    {
        spl_autoload_register(array($this,'__autoload'));
    }

    /**
     * PHPのオートロードからのコールバック
     */
    public function __autoload( $name )
    {
        // オートロード対象かチェックする
        if( !$this->_isMyTarget( $name ) ) return;

        // ファイルが存在するかチェックする
        if( !$filename = $this->_checkFilePath( $name ) ) return;

        require_once $filename;
    }

    private function _isMyTarget( $class_name )
    {
        //var_Dump($this->_namespaces);
        foreach( $this->_namespaces as $namespace=>$directories )
        {
            if( 0 !== strpos( $class_name, $namespace.'\\', 0 ) ) continue;
            return true;
        }
    }

    private function _checkFilePath( $class_name )
    {
        foreach( $this->_namespaces as $namespace=>$directories )
        {
            if( 0 !== strpos( $class_name, $namespace, 0 ) ) continue;

            $path = str_replace('\\','/',substr( $class_name, strlen($namespace)+1 ));
            $path.= '.php';

            // ディレクトリ名とファイル名を分割
            $path_directory_name = dirname($path);
            $path_file_name = basename($path);

            // 検索対象として、class/interface/abstract/traitを追加する
            $search_directories = array('', 'class','interface','abstract','trait');

            foreach( $directories as $dirname )
            {
                $file_path = $this->_findFileSubDirectories( 
                    $dirname.'/'.$path_directory_name,
                    $path_file_name,
                    $search_directories
                );
                if( $file_path ) return $file_path;
            }
        }
    }

    private function _findFileSubDirectories( $dirname, $basename, $sub_directories )
    {
        foreach( $sub_directories as $sub_dirname )
        {
            $file_path = $dirname.'/'.$sub_dirname.'/'.$basename;
            if(file_exists( $file_path )) return $file_path;

        }
        return false;
    }
}
