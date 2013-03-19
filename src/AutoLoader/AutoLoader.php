<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * のらプロジェクト
 *
 * @author     ハジメ <mail@hazime.org>
 * @copyright  opyright (c) 2013, Nora Project All rights reserved.
 * @license    http://www.hazime.org/license/bsd.txt 修正BSDライセンス
 * @version    $Id$
 */
namespace Nora\AutoLoader;
use Nora\General;

require_once 'General/SingletonIF.php';
require_once 'General/SingletonTrait.php';


/**
 * オートローダークラス
 */
class AutoLoader implements AutoLoaderIF,General\SingletonIF
{
    use General\SingletonTrait;

    /**
     * シングルトンオンリーにする。
     * オートロードに登録する。
     */
    private function __construct( )
    {
        // 作成されたらPHPのオートロードに登録
        spl_autoload_register(array($this,'__autoload'));
    }


    /**
     * オートロード対象になるネームスペースを設定
     * 第二引数は検索対象となるディレクトリ
     */
    public function addNamespace( $namespace, $dirctory )
    {
        $this->_namespaces[$namespace][$dirctory] = $dirctory;
        return $this;
    }

    /**
     * 登録されているネームスペースを全件取得
     * デバック目的
     */
    public function getNamespaces( )
    {
        return $this->_namespaces;
    }

    /**
     * PHPのオートロードからのコールバック
     *
     * @exception AutoLoader\FileNotFoundException
     */
    public function __autoload( $name )
    {
        // オートロード対象かチェックする
        if( !$this->_isMyTarget( $name ) ) return;

        $search_log = array();

        // ファイルが存在するかチェックする
        if( !$filename = $this->_checkFilePath( $name, $search_log ) )
        {
            throw new FileNotFoundException( $name, $search_log );
        }

        require_once $filename;
    }

    private function _stringStartsWith( $haystack, $needle )
    {
        return 0 === strpos( $haystack, $needle ) ? true: false;
    }

    private function _convertNamespaceToDirectory( $class_name,$namespace )
    {
        $len = strlen($namespace);
        $path = str_replace('\\','/',substr( $class_name, $len ));
        return $path.'.php';
    }


    private function _isMyTarget( $class_name )
    {
        foreach( $this->_namespaces as $namespace=>$directories )
        {
            if( $this->_stringStartsWith( $class_name, $namespace ) ) return true;
        }
    }

    private function _checkFilePath( $class_name, &$search_log )
    {
        foreach( $this->_namespaces as $namespace=>$directories )
        {
            if( !$this->_stringStartsWith( $class_name, $namespace ) ) continue;

            $path = $this->_convertNamespaceToDirectory( $class_name, $namespace );

            // ディレクトリ名とファイル名を分割
            $path_directory_name = dirname($path);
            $path_file_name      = basename($path);

            // 検索対象として、class/interface/abstract/traitを追加する
            $sub_directories = array('/','/interface/','/trait/','/abstract/','/class/','/exception/');

            foreach( $directories as $dirname )
            {
                foreach( $sub_directories as $sub )
                {
                    $file = $dirname.$path_directory_name.$sub.$path_file_name;
                    if( file_exists($file) ) return $file;
                    $search_log[] = $file;
                }
            }
        }
    }
}

class FileNotFoundException extends \Exception
{
    public function __construct( $class_name, $search_log )
    {
        parent::__construct( sprintf("クラス(%s)が見つかりません。\n検索した場所:%s", $class_name, print_r( $search_log, true ) ));
    }
}
